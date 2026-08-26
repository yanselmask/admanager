
        <footer class="bg-[#0a0f1c]/90 border-t border-cyan-400/20 pt-16 pb-4 mt-24">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Amauri Matom Network</h3>
                        <p class="text-slate-400">La red de monetización digital más avanzada para creadores de contenido.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Servicios</h3>
                        <ul class="text-slate-400 space-y-2">
                            <li><a href="#" class="hover:text-cyan-400">Sistema Exclusivo</a></li>
                            <li><a href="#" class="hover:text-cyan-400">Analytics en Tiempo Real</a></li>
                            <li><a href="#" class="hover:text-cyan-400">Webs Monetizadas</a></li>
                            <li><a href="#" class="hover:text-cyan-400">Red de Referidos</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Soporte</h3>
                        <ul class="text-slate-400 space-y-2">
                            <li><a href="#" class="hover:text-cyan-400">Centro de Ayuda</a></li>
                            <li><a href="#" class="hover:text-cyan-400">Documentación</a></li>
                            <li><a href="#" class="hover:text-cyan-400">Contacto</a></li>
                            <li><a href="#" class="hover:text-cyan-400">Estado del Sistema</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Legal</h3>
                        <ul class="text-slate-400 space-y-2">
                            <li><a href="#" class="hover:text-cyan-400">Términos de Servicio</a></li>
                            <li><a href="#" class="hover:text-cyan-400">Política de Privacidad</a></li>
                            <li><a href="#" class="hover:text-cyan-400">Cookies</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-cyan-400/10 pt-6 text-center text-slate-500 text-sm">
                    <p>{!! Theme::getSiteCopyright() !!}</p>
                </div>
            </div>
        </footer>
        <script>
            // Mobile nav toggle
            document.getElementById('menu-btn').addEventListener('click', function() {
                var nav = document.getElementById('mobile-nav');
                nav.classList.toggle('hidden');
            });
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    if(this.getAttribute('href') !== "#"){
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            window.scrollTo({ top: target.offsetTop - 100, behavior: 'smooth' });
                        }
                    }
                });
            });
        </script>
    </body>
</html>
