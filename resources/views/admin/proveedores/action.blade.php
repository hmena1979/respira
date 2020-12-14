@if($tipo=='2')
<div class="opts">
    @if(kvfj(Auth::user()->permissions,'proveedor_edit'))
    <a href="{{ route('proveedor_edit', $id) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
    @endif
    @if(kvfj(Auth::user()->permissions,'proveedor_delete'))
    <a href="{{ route('proveedor_delete', $id) }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
    @endif											
</div>
@endif