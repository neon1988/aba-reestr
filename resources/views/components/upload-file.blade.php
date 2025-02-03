@props(['parent_value_name' => '', 'max_files' => 5, 'url'])

<div x-data="fileUploadHandler({{ $max_files }}, '{{ $url}}')"
     x-init="files = normalizeFiles({{ $parent_value_name }})"
     x-effect="{{ $parent_value_name }} = denormalizeFiles(files)">

    <div class="max-w-md bg-white rounded-lg overflow-hidden">
        <ul>
            <!-- Карточки файлов -->
            <template x-for="(file, index) in files" :key="index">
                <!-- Элемент списка -->
                <li class="flex items-center p-4 hover:bg-gray-100">
                    <div class="flex-shrink-0">
                        <a :href="file.url" target="_blank"
                           class="w-10 h-10 bg-cyan-500 text-white rounded-full flex justify-center items-center">
                            <template x-if="!isImage(file.name)">
                                <span x-text="file.extension"></span>
                            </template>
                            <template x-if="isImage(file.name) && file.url">
                                <img :src="makeImageSmaller(file)"
                                     alt="file" class="w-10 h-10 object-cover rounded-full">
                            </template>
                        </a>
                    </div>

                    <div class="mx-4">
                        <h4 class="w-32 text-lg font-medium text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap"
                            x-text="file.name"></h4>

                        <template x-if="uploadProgress[index]">
                            <div>
                                <!-- Уведомления -->
                                <p x-show="uploadProgress[index].loading" class="text-sm text-gray-600 mt-1">
                                    <progress class="w-full" :value="uploadProgress[index].progress" max="100"></progress>
                                    <span x-text="`${uploadProgress[index].progress}%`"></span>
                                </p>

                                <template x-if="uploadProgress[index].success">
                                    <div class="text-sm text-green-600 font-medium">Файл успешно загружен</div>
                                </template>

                                <!-- Ошибки -->
                                <template x-if="uploadProgress[index].errors && uploadProgress[index].errors.length > 0">
                                    <template x-for="(error, errorIndex) in uploadProgress[index].errors" :key="errorIndex">
                                        <div class="text-sm text-red-600 font-medium" x-text="error"></div>
                                    </template>
                                </template>
                            </div>
                        </template>
                    </div>

                    <div @click="removeFile(index)"
                         class="cursor-pointer text-ellipsis overflow-hidden ml-auto bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Удалить
                    </div>

                </li>
            </template>
        </ul>
    </div>

    <input
        type="file"
        multiple
        @change="handleFiles"
        x-show="files.length < maxFiles"
        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100"
    />

    <input type="hidden" x-model="files"/>
</div>

<script>
    function fileUploadHandler(maxFiles, url) {
        return {
            uploadProgress: [],
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
                    const index = this.files.length;

                    this.uploadProgress[index] = {
                        file: file,
                        loading: false,
                        progress: 0,
                        success: false,
                        error: null
                    }

                    this.uploadFile(index);
                });
            },
            // Загрузка каждого файла
            async uploadFile(index) {
                this.uploadProgress[index].loading = true;
                this.uploadProgress[index].progress = 0;
                this.uploadProgress[index].errors = [];
                this.files[index] = {
                    name: this.uploadProgress[index].file.name
                };

                try {
                    const formData = new FormData();
                    formData.append('file', this.uploadProgress[index].file);

                    // Отправляем файл на сервер
                    const response = await axios.post(this.url, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                        onUploadProgress: (event) => {
                            this.uploadProgress[index].progress = Math.round((event.loaded / event.total) * 100);
                        },
                    });

                    this.files[index] = response.data.data;
                    this.uploadProgress[index].success = true;
                    this.uploadProgress[index].percent = 100;
                    this.uploadProgress[index].url = this.files[index].url;
                    this.uploadProgress[index].name = this.files[index].name;
                    this.uploadProgress[index].extension =
                        this.uploadProgress[index].name.split('.').pop().toLowerCase();
                } catch (err) {
                    if (err.status === 422) {
                        this.uploadProgress[index].errors = Object.values(err.response.data.errors)[0];
                    } else {
                        // Обрабатываем ошибку
                        this.uploadProgress[index].errors[0] = 'Ошибка при загрузке файла';
                    }
                } finally {
                    this.uploadProgress[index].loading = false;
                    this.$nextTick(() => {
                        this.$dispatch('change');
                    });
                }
            },

            isImage(name) {
                if (name === undefined)
                    return false;
                const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                return imageExtensions.some((ext) => name.toLowerCase().endsWith(ext));
            },

            // Удаление файла
            removeFile(index) {
                this.$nextTick(() => {
                    this.files.splice(index, 1);
                    this.uploadProgress.splice(index, 1);

                    this.$dispatch('change');
                });
            },

            normalizeFiles(value) {
                return Array.isArray(value) ? value : value ? [value] : [];
            },

            denormalizeFiles(files) {
                if (this.maxFiles > 1) {
                    return files; // Массив
                } else {
                    return files ? files[0] : null; // Один объект
                }
            },

            makeImageSmaller(file, w = 100, h = 100, q = 90) {
                let url = new URL(file.url);
                if (this.isImage(file.url)) {
                    url.searchParams.set('w', w);
                    url.searchParams.set('h', h);
                    url.searchParams.set('q', q);
                }
                return url.toString();
            }
        };
    }
</script>
