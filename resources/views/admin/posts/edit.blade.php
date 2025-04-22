<x-layouts.app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Inicio</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">Posts</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="card">
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <flux:input label="Titulo" id="title" name="title" value="{{ old('title', $post->title) }}"
                placeholder="Ingrese el titulo de el post" />

            <flux:input label="Slug" name="slug" id="slug" value="{{ old('slug', $post->slug) }}"
                placeholder="Slug generado" readonly />

            <flux:select label="Categoria" name="category_id" wire:model="category"
                placeholder="Seleccione una categoria">
                @foreach ($categories as $category)
                    <flux:select.option value="{{ $category->id }}" :selected="$category->id == old('category_id', $post->category_id)">
                        {{ $category->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:textarea label="Resumen" name="excerpt">{{old('excerpt', $post->excerpt)}}</flux:textarea>

            <flux:textarea label="Contenido" name="content" rows="16">{{old('content', $post->content)}}</flux:textarea>

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

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">Enviar</flux:button>
            </div>
        </form>
    </div>

    @push('js')
        {{-- <script>
            function string_to_slug(str, querySelector) {
                // Eliminar espacios al inicio y final
                str = str.replace(/^\s+|\s+$/g, '');

                // Convertir todo a minúsculas
                str = str.toLowerCase();

                // Definir caracteres especiales y sus reemplazos
                var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
                var to = "aaaaeeeeiiiioooouuuunc------";

                // Reemplazar caracteres especiales por los correspondientes en 'to'
                for (var i = 0, l = from.length; i < l; i++) {
                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                }

                // Eliminar caracteres no alfanuméricos y reemplazar espacios por guiones
                str = str.replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');

                // Asignar el slug generado al campo de entrada correspondiente
                document.querySelector(querySelector).value = str;
            }
        </script> --}}
    @endpush
</x-layouts.app>
