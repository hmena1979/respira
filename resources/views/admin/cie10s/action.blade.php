@if(kvfj(Auth::user()->permissions,'cie10_edit'))
<a href="{{ route('cie10_edit', $id) }}" datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
@endif
@if(kvfj(Auth::user()->permissions,'cie10_delete'))
<a href="{{ route('cie10_delete', $id) }}" datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
@endif
