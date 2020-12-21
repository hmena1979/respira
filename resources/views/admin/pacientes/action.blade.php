

<div class="opts">
    @if(kvfj(Auth::user()->permissions,'paciente_edit'))
    <a href="{{ route('paciente_edit', $id) }}"datatoggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
    @endif
    @if(kvfj(Auth::user()->permissions,'paciente_appointment'))
    <a href="{{ route('paciente_appointment', $id) }}"datatoggle="tooltip" data-placement="top" title="Programar cita"><i class="fas fa-laptop-medical"></i></a>
    @endif
    @if(kvfj(Auth::user()->permissions,'historias'))
    <a href="{{ route('historias', [$id,'item'=>'001'])}}"datatoggle="tooltip" data-placement="top" title="Historia"><i class="fas fa-book-medical"></i></a>
    @endif
    {{-- @if(kvfj(Auth::user()->permissions,'paciente_delete'))
    <a href="{{ route('paciente_delete', $id) }}"datatoggle="tooltip" data-placement="top" title="Eliminar" onclick="return confirm('Desea eliminar el registro?')"><i class="fas fa-trash-alt"></i></a>
    @endif											 --}}
</div>