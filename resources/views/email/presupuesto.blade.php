@component('mail::message')
# Actualización de usuario

Se ha creado con éxito un nuevo presupuesto

@component('mail::button', ['url' => url($presupuesto->pdf)])
    Ver Comprobante
    
@endcomponent

Gracias!!!
<br>

{{ config('app.name') }}

@endcomponent
