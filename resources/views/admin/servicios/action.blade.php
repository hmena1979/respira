

<div class="opts">
    @if(kvfj(Auth::user()->permissions,'servicio_edit'))
    <a href="{{ route('servicio_edit', $id) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
    @endif
    @if(kvfj(Auth::user()->permissions,'servicio_delete'))
    <a href="{{ route('servicio_delete', $id) }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
    @endif											
</div>