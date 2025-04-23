<x-layouts.app>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    @endpush

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Inicio</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">Posts</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" class="space-y-4"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="relative mb-2">
            {{-- <img id="imgPreview" class="w-full aspect-video object-cover object-center"
                src="{{ $post->image_path ? Storage::url($post->image_path) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' }}"
                alt="Imagen del post"> --}}
            <img id="imgPreview" class="w-full aspect-video object-cover object-center"
                src="{{ $post->image_path ? asset('storage/' . $post->image_path) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' }}"
                alt="Imagen del post">
            <div class="absolute top-8 right-8">
                <label for="image" class="bg-white px-4 py-2 rounded-lg cursor-pointer">
                    Cambiar Imagen
                    <input type="file" name="image" accept="image/*" onchange="previewImage(event, '#imgPreview')">
                </label>
            </div>
        </div>
        <div class="card space-y-4">
            <flux:input label="Titulo" id="title" name="title" value="{{ old('title', $post->title) }}"
                placeholder="Ingrese el titulo de el post" />

            <flux:input label="Slug" name="slug" id="slug" value="{{ old('slug', $post->slug) }}"
                placeholder="Slug generado" readonly />

            <flux:select label="Categoria" name="category_id" wire:model="category"
                placeholder="Seleccione una categoria">
                @foreach ($categories as $category)
                    <flux:select.option value="{{ $category->id }}"
                        :selected="$category->id == old('category_id', $post->category_id)">
                        {{ $category->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:textarea label="Resumen" name="excerpt">{{ old('excerpt', $post->excerpt) }}</flux:textarea>

            {{-- <flux:textarea label="Contenido" name="content" rows="16">{{ old('content', $post->content) }}</flux:textarea> --}}

            <div>
                <p class="font-medium text-sm mb-1">Contenido</p>
                <div id="editor">{!! old('content', $post->content) !!}</div>

                <textarea class="hidden" name="content" id="content">{{ old('content', $post->content) }}</textarea>
            </div>

            <div>
                <p class="text-sm font-medium mb-1">Etiquetas</p>

                <ul>
                    @foreach ($tags as $tag)
                        <li>
                            <label for="{{ 'tag' . $tag->id }}" class="flex items-center space-x-2">
                                <input type="checkbox" name="tags[]" id="{{ 'tag' . $tag->id }}"
                                    value="{{ $tag->id }}"
                                    @checked(in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())))><span>{{ $tag->name }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="text-sm font-medium mb-1">Estado</p>
                <div class="flex space-x-3">
                    <label for="is_published" class="flex items-center">
                        <input type="radio" name="is_published" value="0" @checked(old('is_published', $post->is_published) == 0)>
                        <span class="ml-1">No publicado</span>
                    </label>

                    <label for="is_published" class="flex items-center">
                        <input type="radio" name="is_published" value="1" @checked(old('is_published', $post->is_published) == 1)>
                        <span class="ml-1">Publicado</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">Enviar</flux:button>
            </div>
        </div>
    </form>

    @push('js')
        <!-- Include the Quill library -->
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        <!-- Initialize Quill editor -->
        <script>
            const quill = new Quill('#editor', {
                theme: 'snow'
            });

            quill.on('text-change', function(){
                document.querySelector('#content').value = quill.root.innerHTML;
            });
        </script>
    @endpush
</x-layouts.app>
