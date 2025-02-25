<?php

namespace Botble\Member\Http\Controllers;

use Botble\ACL\Models\User;
use Botble\Admanager\Services\Admanager;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\Assets;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Blog\Models\Post;
use Botble\CustomField\Facades\CustomField;
use Botble\CustomField\Models\FieldGroup;
use Botble\Domain\Models\Domain;
use Botble\Media\Chunks\Exceptions\UploadMissingFileException;
use Botble\Media\Chunks\Handler\DropZoneUploadHandler;
use Botble\Media\Chunks\Receiver\FileReceiver;
use Botble\Media\Facades\RvMedia;
use Botble\Media\Models\MediaFile;
use Botble\Member\Forms\CustomForm;
use Botble\Member\Forms\Fronts\ChangePasswordForm;
use Botble\Member\Forms\Fronts\ProfileForm;
use Botble\Member\Forms\KycFrontForm;
use Botble\Member\Http\Requests\AvatarRequest;
use Botble\Member\Http\Requests\KycRequest;
use Botble\Member\Http\Requests\SettingRequest;
use Botble\Member\Http\Requests\UpdatePasswordRequest;
use Botble\Member\Http\Resources\ActivityLogResource;
use Botble\Member\Models\Invoice;
use Botble\Member\Models\Member;
use Botble\Member\Models\MemberActivityLog;
use Botble\Member\Tables\InvoiceFrontTable;
use Botble\Member\Tables\InvoiceTable;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\SeoHelper\SeoOpenGraph;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Facades\Theme;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PublicController extends BaseController
{
    public function getAuthor(string $slug)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Member::class), Member::class);
        abort_unless($slug, 404);

        $condition = [
            'id' => $slug->reference_id,
            'status' => BaseStatusEnum::PUBLISHED,
        ];

        if (Auth::guard()->check() && request('preview')) {
            Arr::forget($condition, 'status');
        }

        $author = Member::query()
            ->where($condition)
            ->with(['slugable'])
            ->firstOrFail();

        SeoHelper::setTitle($author->name)->setDescription($author->description);

        $meta = new SeoOpenGraph();
        if ($author->avatar) {
            $meta->setImage(RvMedia::getImageUrl($author->avatar));
        }
        $meta->setDescription($author->description);
        $meta->setUrl($author->url);
        $meta->setTitle($author->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        Theme::breadcrumb()->add($author->name, $author->url);

        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, MEMBER_MODULE_SCREEN_NAME, $author);

        $posts = Post::query()
            ->wherePublished()
            ->where([
                'author_id' => $author->getKey(),
                'author_type' => Member::class,
            ])
            ->orderByDesc('created_at')
            ->paginate(12);

        return Theme::scope('author', compact('author', 'posts'), 'plugins/member::themes.author')->render();
    }

    public function getDashboard()
    {
        $user = auth('member')->user();

        $domain = Domain::where('member_id', $user->id)->first();

        $optionsGraf = [];

        if(json_decode(setting('earning_member')))
        {
            array_push($optionsGraf, 'ganancias');
        }
        if(json_decode(setting('impressions_member')))
        {
            array_push($optionsGraf, 'impresiones');
        }
        if(json_decode(setting('clicks_member')))
        {
            array_push($optionsGraf, 'clicks');
        }
        if(json_decode(setting('ctrs_member')))
        {
            array_push($optionsGraf, 'ctrs');
        }
        if(json_decode(setting('ecpms_member')))
        {
            array_push($optionsGraf, 'ecpm');
        }


        if($dname = request()->input('domain'))
        {
            $domain = Domain::where('url', $dname)->where('member_id', $user->id)->first();

            if(!$domain)
            {
                $domain = Domain::where('member_id', $user->id)->first();
            }
        }

        $this->pageTitle(__('Estadisticas'));

        Assets::addScriptsDirectly('vendor/core/core/base/libraries/ckeditor/ckeditor.js');

        return view('plugins/member::themes.dashboard.index', compact('user','domain','optionsGraf'));
    }

    public function getKycForm()
    {
        $this->pageTitle(__('Kyc'));

        $form = KycFrontForm::create()->renderForm();

        $user = auth('member')->user();

        return view('plugins/member::themes.dashboard.kyc', compact('form', 'user'));
    }

    public function postKyc(KycRequest $request)
    {
        $validated = $this->processRequestDataKyc($request);


        KycFrontForm::createFromModel(auth('member')->user())
            ->saving(function (KycFrontForm $form) use ($request): void {
                $model = $form->getModel();

                $model->kyc()->updateOrCreate(
                    ['member_id' => $model->id],
                    [
                        'name' => $request->name,
                        'last_name' => $request->last_name,
                        'address' => $request->address,
                        'nationality' => $request->nationality,
                        'document_type' => $request->document_type,
                        'document_number' => $request->document_number,
                        'document_front' => $request->document_front,
                        'document_back' => $request->document_back,
                        'selfie' => $request->selfie,
                        'status' => 'pending'
                    ]
                );

            });


        MemberActivityLog::query()->create([
            'action' => 'kyc_send',
        ]);

        return $this
            ->httpResponse()
            ->setNextRoute('public.member.settings')
            ->setMessage(__('Kyc sent successfully!'));
    }

    public function getSettings()
    {
        $this->pageTitle(__('Account settings'));

        /**
         * @var User $user
         */
        $user = auth('member')->user();

        Assets::addScripts('form-validation');

        $profileForm = ProfileForm::createFromModel($user)->renderForm();
        $changePasswordForm = ChangePasswordForm::create()->renderForm();
        $customForm = CustomForm::createFromModel($user);

        return view(
            'plugins/member::themes.dashboard.settings.index',
            compact('user', 'profileForm', 'changePasswordForm','customForm')
        );
    }

    public function postSettings(SettingRequest $request)
    {
        ProfileForm::createFromModel(auth('member')->user())
            ->saving(function (ProfileForm $form) use ($request): void {
                $model = $form->getModel();

                $model->update(Arr::except($request->validated(), 'email'));
            });

        MemberActivityLog::query()->create([
            'action' => 'update_setting',
        ]);

        return $this
            ->httpResponse()
            ->setNextRoute('public.member.settings')
            ->setMessage(__('Update profile successfully!'));
    }

    public function postCustomFields(Request $request)
    {
        $validated = $request->validate([]);
        CUstomForm::createFromModel(auth('member')->user())
            ->saving(function (CUstomForm $form) use ($request): void {
                $model = $form->getModel();

                $model->update($request->all());
            });

        MemberActivityLog::query()->create([
            'action' => 'update_custom_field',
        ]);

        return $this
            ->httpResponse()
            ->setNextRoute('public.member.settings')
            ->setMessage(__('Update profile successfully!'));
    }

    public function postSecurity(UpdatePasswordRequest $request)
    {
        $request->user('member')->update([
            'password' => $request->input('password'),
        ]);

        MemberActivityLog::query()->create(['action' => 'update_security']);

        return $this
            ->httpResponse()
            ->setMessage(trans('plugins/member::dashboard.password_update_success'));
    }

    public function postAvatar(AvatarRequest $request)
    {
        try {
            $account = auth('member')->user();

            $result = RvMedia::uploadFromBlob($request->file('avatar_file'), folderSlug: $account->upload_folder);

            if ($result['error']) {
                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage($result['message']);
            }

            $file = $result['data'];

            $mediaFile = MediaFile::query()->find($account->avatar_id);
            $mediaFile?->forceDelete();

            $account->avatar_id = $file->id;
            $account->save();

            MemberActivityLog::query()->create([
                'action' => 'changed_avatar',
            ]);

            return $this
                ->httpResponse()
                ->setMessage(trans('plugins/member::dashboard.update_avatar_success'))
                ->setData(['url' => RvMedia::url($file->url)]);
        } catch (Exception $exception) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function getActivityLogs()
    {
        $activities = MemberActivityLog::query()
            ->where('member_id', auth('member')->id())
            ->latest()
            ->paginate();

        return $this
            ->httpResponse()
            ->setData(ActivityLogResource::collection($activities))
            ->toApiResponse();
    }

    public function postUpload(Request $request)
    {
        $account = auth('member')->user();

        if (! RvMedia::isChunkUploadEnabled()) {
            $validator = Validator::make($request->all(), [
                'file.0' => RvMedia::imageValidationRule(),
            ]);

            if ($validator->fails()) {
                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage($validator->getMessageBag()->first());
            }

            $result = RvMedia::handleUpload(Arr::first($request->file('file')), 0, $account->upload_folder);

            if ($result['error']) {
                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage($result['message']);
            }

            return $this
                ->httpResponse()
                ->setData($result['data']);
        }

        try {
            // Create the file receiver
            $receiver = new FileReceiver('file', $request, DropZoneUploadHandler::class);
            // Check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }
            // Receive the file
            $save = $receiver->receive();
            // Check if the upload has finished (in chunk mode it will send smaller files)
            if ($save->isFinished()) {
                $result = RvMedia::handleUpload($save->getFile(), 0, $account->upload_folder);

                if (! $result['error']) {
                    return $this
                        ->httpResponse()
                        ->setData($result['data']);
                }

                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage($result['message']);
            }
            // We are in chunk mode, lets send the current progress
            $handler = $save->handler();

            return response()->json([
                'done' => $handler->getPercentageDone(),
                'status' => true,
            ]);
        } catch (Exception $exception) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function postUploadFromEditor(Request $request)
    {
        $account = auth('member')->user();

        return RvMedia::uploadFromEditor($request, 0, $account->upload_folder);
    }

    public function getReferrals()
    {
        $user = auth('member')->user();

        $this->pageTitle(__('Referidos - $:balance', ['balance' => (int) $user->getMetaData('balances', true)]));

        $referrals = $user->referrals()->paginate();

        return view('plugins/member::themes.dashboard.referrals', compact('user','referrals'));
    }

    protected function processRequestDataKyc(Request $request): Request
    {
        $model = auth('member')->user();

        if ($request->hasFile('document_front_input')) {
            $result = RvMedia::handleUpload($request->file('document_front_input'), 0, $model->upload_folder);
            if (! $result['error']) {
                $file = $result['data'];
                $request->merge(['document_front' => $file->url]);
            }
        }

        if ($request->hasFile('document_back_input')) {
            $result = RvMedia::handleUpload($request->file('document_back_input'), 0, $model->upload_folder);
            if (! $result['error']) {
                $file = $result['data'];
                $request->merge(['document_back' => $file->url]);
            }
        }

        if ($request->hasFile('selfie_input')) {
            $result = RvMedia::handleUpload($request->file('selfie_input'), 0, $model->upload_folder);
            if (! $result['error']) {
                $file = $result['data'];
                $request->merge(['selfie' => $file->url]);
            }
        }

        return $request;
    }

    public function getInvoices()
    {
        $this->pageTitle(__('Pagos'));
        $user = auth('member')->user();
        $invoices = Invoice::query()->where('member_id', auth('member')->id())->latest()->paginate();

        return view('plugins/member::themes.dashboard.invoices', compact('user', 'invoices'));
    }

}
