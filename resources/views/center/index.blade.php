@extends('layouts.app')

@section('content')

    <div x-data="searchResults()" x-init="container = $refs.contentElement.innerHTML">
        <!-- Search Section -->
        <section class="py-12 bg-white rounded-t">
            <div class="container mx-auto text-center">
                <h2 class="text-3xl font-semibold text-gray-900 mb-6">Поиск центров ABA</h2>
                <form @submit.prevent="submitForm" x-ref="form" action="{{ route('centers.index') }}" method="get"
                      enctype="multipart/form-data" class="space-y-6">
                    <!-- Простое поле поиска -->
                    <div class="flex justify-center space-x-4">
                        <input name="search" x-model.debounce.500ms="formData.search" value="{{ Request::input('search') }}" type="text"
                               placeholder="Поиск по названию или городу или ИНН"
                               class="w-1/3 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <button type="submit"
                                class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                            Поиск
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Centers List Section -->
        <section id="centers" class="py-16 px-5 bg-gray-50 rounded-b">
            <!-- Заглушка -->
            <div x-show="isLoading" x-transition
                 class="absolute inset-0 bg-gray-200 bg-opacity-75 flex justify-center items-center z-10">
                <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
            </div>
            <div x-html="container" x-ref="contentElement" class="container mx-auto text-center">
                @include('center.list')
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
