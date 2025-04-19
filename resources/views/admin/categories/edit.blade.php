<x-layouts.app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Inicio</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('admin.categories.index') }}">Categorias</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="card">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <flux:input label="Nombre" name="name" value="{{ old('name', $category->name) }}"
                placeholder="Ingrese el nombre de la categoria" />
            <div class="flex justify-end mt-4">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-blue mr-2">Volver</a>
                <flux:button variant="primary" type="submit">Enviar</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
