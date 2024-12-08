@props(['parent_value_name' => '', 'max_files' => 5, 'url'])

<div x-data="fileUploadHandler({{ $max_files }}, '{{ $url}}')"
     x-init="$watch('{{ $parent_value_name }}', value => files = value)"
     x-effect="{{ $parent_value_name }} = files">

    <!-- Поле для выбора файлов -->
    <input
        type="file"
        multiple
        @change="handleFiles"
        x-show="files.length < maxFiles"
        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100"
    />

    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden">
        <ul>
            <!-- Карточки файлов -->
            <template x-for="(file, index) in files" :key="index">
                <!-- Элемент списка -->
                <li class="flex items-center p-4 hover:bg-gray-100">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-cyan-500 text-white rounded-full flex justify-center">
                            <img x-show="file.isImage" :src="file.url || 'https://via.placeholder.com/100'"
                                 alt="file" class="w-10 h-10 object-cover rounded-full">
                        </div>
                    </div>
                    <div class="mx-4">
                        <h4 class="w-48 text-lg font-medium text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap" x-text="file.name"></h4>

                        <!-- Уведомления -->
                        <p x-show="file.loading" class="text-sm text-gray-600 mt-1">
                            <progress class="w-full" :value="file.progress" max="100"></progress>
                            <span x-text="`${file.progress}%`"></span>
                        </p>
                        <template x-if="file.success">
                            <div class="text-sm text-green-600 font-medium">Файл успешно загружен</div>
                        </template>

                        <template x-for="(error, index) in file.errors" :key="index">
                            <div class="text-sm text-red-600 font-medium" x-text="error"></div>
                        </template>
                    </div>
                    <button @click="removeFile(index)"
                            class="ml-auto bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Удалить
                    </button>
                </li>
            </template>
        </ul>
    </div>

    <input type="hidden" x-model="files"/>
</div>

<script>
    function fileUploadHandler(maxFiles, url) {
        return {
            files: [], // Массив для хранения файлов
            maxFiles: maxFiles, // Максимальное количество файлов
            url: url,

            // Обработчик выбора файлов
            handleFiles(event) {
                const selectedFiles = Array.from(event.target.files);
                event.target.value = '';
                if (this.files.length + selectedFiles.length > this.maxFiles) {
                    alert(`Максимальное количество файлов: ${this.maxFiles}`);
                    return;
                }

                selectedFiles.forEach(file => {
                    this.files.push({
                        file: file,
                        name: file.name,
                        loading: false,
                        progress: 0,
                        success: false,
                        error: null
                    });
                    this.uploadFile(file);
                });
            },

            // Загрузка каждого файла
            async uploadFile(file) {
                const index = this.files.findIndex(f => f.file === file);
                if (index === -1) return;

                this.files[index].loading = true;
                this.files[index].progress = 0;
                this.files[index].success = false;
                this.files[index].errors = [];

                try {
                    const formData = new FormData();
                    formData.append('file', file);

                    // Отправляем файл на сервер
                    const response = await axios.post(this.url, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                        onUploadProgress: (event) => {
                            this.files[index].progress = Math.round((event.loaded / event.total) * 100);
                        },
                    });

                    // Обрабатываем успешный ответ
                    this.files[index].success = true;
                    this.files[index].path = response.data.path;
                    this.files[index].hash = response.data.hash;
                    this.files[index].isImage = response.data.isImage;
                    this.files[index].mimeType = response.data.mimeType;
                    this.files[index].url = response.data.url

                    if (response.data.isImage) {
                        const url = new URL(this.files[index].url);
                        url.searchParams.set('w', 200);
                        url.searchParams.set('h', 200);
                        url.searchParams.set('q', 90);
                        this.files[index].url = url.toString();
                    }

                    console.log('Файл успешно загружен:', response.data);
                } catch (err) {
                    if (err.status === 422) {
                        this.files[index].errors = Object.values(err.response.data.errors)[0];
                        console.error(Object.values(err.response.data.errors)[0]);
                    } else {
                        // Обрабатываем ошибку
                        this.files[index].errors[0] = 'Ошибка при загрузке файла';
                        console.error(err);
                    }
                } finally {
                    this.files[index].loading = false;
                }
            },

            // Удаление файла
            removeFile(index) {
                this.files.splice(index, 1);
            }
        };
    }
</script>
