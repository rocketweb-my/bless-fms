		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
		<!-- JQUERY JS -->
		<script src="{{ URL::asset('assets/js/jquery-3.4.1.min.js') }}"></script>

        <!-- VUE JS -->
        <script src="{{ URL::asset('assets/js/vue.js') }}"></script>

        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

        <!-- Global Language Switcher Function -->
        <script>
            function changeLanguage(language) {
                axios.post('{{ route('set.language') }}', {
                    language: language,
                    _token: '{{ csrf_token() }}'
                })
                .then(function (response) {
                    if (response.data.success) {
                        // Reload the page to reflect the language change
                        window.location.reload();
                    }
                })
                .catch(function (error) {
                    console.error('Language switch failed:', error);
                });
            }
        </script>

		<!-- BOOTSTRAP JS -->
		<script src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ URL::asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>

		<!-- SPARKLINE JS-->
		<script src="{{ URL::asset('assets/js/jquery.sparkline.min.js') }}"></script>

		<!-- CHART-CIRCLE JS -->
		<script src="{{ URL::asset('assets/js/circle-progress.min.js') }}"></script>

		<!-- RATING STAR JS-->
		<script src="{{ URL::asset('assets/plugins/rating/jquery.rating-stars.js') }}"></script>

		<!-- C3.JS CHART JS -->
		<script src="{{ URL::asset('assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
		<script src="{{ URL::asset('assets/plugins/charts-c3/c3-chart.js') }}"></script>

		<!-- INPUT MASK JS-->
		<script src="{{ URL::asset('assets/plugins/input-mask/jquery.mask.min.js') }}"></script>



        <!-- CUSTOM SCROLLBAR JS-->
		<script src="{{ URL::asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js') }}"></script>

        <!--Sweet Alert -->
        <script src="{{ URL::asset('assets/js/sweetalert2.js') }}"></script>

        <!--Toastr-->
        {{-- @toastr_js
        @toastr_render --}}

		@yield('js')

        <!-- SIDE-MENU JS-->
        <script src="{{ URL::asset('assets/plugins/sidemenu/sidemenu.js') }}"></script>

		<!-- SIDEBAR JS -->
		<script src="{{ URL::asset('assets/plugins/sidebar/sidebar.js') }}"></script>

		<!--CUSTOM JS -->
		<script src="{{ URL::asset('assets/js/custom.js') }}"></script>




