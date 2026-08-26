@extends(Theme::getThemeNamespace('views.member.dashboard') . '.layouts.master')

@section('content')
    {!! apply_filters(MEMBER_TOP_STATISTIC_FILTER, null) !!}
    <div class="row g-0 h-100">
        <div class="col-12 mb-3">
            <div class="card bg-body-tertiary dark__bg-opacity-50 shadow-none">
                <div class="d-flex justify-content-center justify-content-md-start align-items-center z-1 p-0">
                    <div class="">
                        <h4 class="mb-0 text-info fw-bold text-center text-md-start" style="font-size: 2.5rem">Referidos</h4>
                        <button type="button" class="btn btn-primary btn-ref mt-2"><span class="fas fa-link text-center"></span>&nbsp;Compartir mi enlace de referidos</button>
                        <input type="text" style="position:absolute; left:-9999px;" name="ref_by" value="{{route('public.member.register') . '?ref_by=' . auth('member')->user()?->username}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center justify-content-md-start">
        @forelse($referrals as $ref)
            <div class="col mb-3">
                <div class="card overflow-hidden" style="background-color: #011635;border: 1px solid #052655">
                    <div class="card-body d-flex">
                        <div class="d-flex justify-content-center align-items-center" style="height: 45px;width: 45px; border: 1px solid #052655;border-radius: 50%;">
                            <span style="color: #0B63E4;font-size: 1.5rem;" class="fas fa-user text-center"></span>
                        </div>
                        <div class="ms-3">
                            <h5 class="card-title">{{$ref->first_name}}</h5>
                            <p class="card-text">{{$ref->username}}</p>
                        </div>
                        @if(MetaBox::getMetaData($ref, 'balances', true))
                        <div class="ms-2 align-self-center">
                            <span class="fw-semi-bold text-white">${{round(MetaBox::getMetaData($ref, 'balances', true), 2)}}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-5 col-sm-12 mb-3">
                <div class="card overflow-hidden" style="background-color: #011635;border: 1px solid #052655">
                    <div class="card-body d-flex">
                        <div class="d-flex justify-content-center align-items-center" style="height: 45px;width: 45px; border: 1px solid #052655;border-radius: 50%;">
                            <span style="color: #0B63E4;font-size: 1.5rem;" class="fas fa-user text-center"></span>
                        </div>
                        <div class="ms-3">
                            <h5 class="card-title">Sin referidos</h5>
                            <p class="card-text">Aún no tienes referidos</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    {{$referrals->links()}}
@stop
@push('scripts')
    <script>
        let refByInput = document.querySelector('[name=ref_by]');
        let btnRef = document.querySelector('.btn-ref');

        btnRef.onclick = () => {
            if(refByInput)
            {
                toastMagic.success("Exito!", "Enlace copiado!");
                refByInput.select();
                refByInput.setSelectionRange(0, 99999);
                document.execCommand("copy");
            }
        }
    </script>
@endpush
