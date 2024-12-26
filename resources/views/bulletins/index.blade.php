@extends('layouts.app')

@section('content')

    <div x-data="searchResults()" x-init="container = $refs.contentElement.innerHTML">
        <!-- Search Section -->
        <section class="pt-4 pb-4 sm:pb-12 bg-white rounded-t">
            <div class="container mx-auto text-center">
                <form @submit.prevent="submitForm" x-ref="form" action="{{ route('bulletins.index') }}" method="get"
                      enctype="multipart/form-data" class="space-y-6">
                    <!-- Простое поле поиска -->
                    <div class="flex justify-center px-3 sm:space-x-4 flex-col sm:flex-row">
                        <a href="{{ route('bulletins.create') }}"
                           class="bg-cyan-600 text-white py-3 px-6 mb-3 sm:mb-0 rounded-lg hover:bg-cyan-700 transition duration-300 text-nowrap">
                            Создать объявление
                        </a>
                        <div class="w-full flex flex-row">
                            <input name="search" x-model.debounce.500ms="formData.search"
                                   value="{{ Request::input('search') }}" type="text"
                                   placeholder="Введите уровень подготовки, опыт работы, город/район, занятость, возраст ребенка, область работы, контактные данные"
                                   class="p-3 mr-3 grow  border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Centers List Section -->
        <section id="bulletins" class="pb-4 px-2 lg:px-4 bg-gray-50 sm:rounded-b">
            <div x-html="container" x-ref="contentElement" class="container mx-auto">
                @include('bulletins.list', ['items' => $items])
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
