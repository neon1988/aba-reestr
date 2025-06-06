@extends('layouts.app')

@section('content')

    <div x-data="searchResults()" x-init="container = $refs.contentElement.innerHTML">
        <!-- Search Section -->
        <section class="pt-6 pb-6 bg-white sm:rounded-t-lg">
            <div class="container mx-auto text-center">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Поиск специалистов ABA</h2>
                <form @submit.prevent="submitForm" x-ref="form" action="{{ route('specialists.index') }}" method="get" enctype="multipart/form-data">
                    <div class="flex justify-center space-x-4 flex-wrap">
                        <input name="search" x-model.debounce.500ms="formData.search"  type="text" value="{{ Request::input('search') }}"
                               placeholder="Поиск по ФИО или городу или центру"
                               class="sm:w-1/3 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <button type="submit"
                                class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                            Поиск
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Specialists List Section -->
        <section id="specialists" class="py-4 lg:pb-16 px-4 lg:px-8 bg-gray-50 sm:rounded-b-lg">
            <div x-html="container" x-ref="contentElement" class="container mx-auto text-center">
                @include('specialists.list')
            </div>
            <!-- Заглушка -->
            <div x-show="isLoading" x-transition
                 class="absolute inset-0 bg-gray-200 bg-opacity-75 flex justify-center items-center z-10">
                <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-cyan-500"></div>
            </div>
        </section>
    </div>

    <script>
        function searchResults() {
            return {
                formData: {
                    search: '',
                },
                isLoading: false,
                init() {
                    this.$watch('formData', () => {
                        this.submitForm();
                    });
                },
                // Функция для отправки формы
                async submitForm() {
                    this.isLoading = true

                    const url = new URL(this.$refs.form.getAttribute('action'));
                    url.search = new URLSearchParams(this.formData).toString();

                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    });

                    if (response.ok) {
                        this.isLoading = false
                        let json = await response.json()
                        this.container = json['view']
                    } else {
                        // Получаем ошибки валидации и отображаем их
                        this.isLoading = false
                    }
                }
            };
        }
    </script>

@endsection
