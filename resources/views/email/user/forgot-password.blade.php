@component('mail::message')

Se ha realizado un pedido para cambio de contraseña, asociada a
su correo electrónico {{ $email }}


Importante!
Si no reconoce este correo haga caso omiso

@component('mail::button', ['url' => Request::root().'/#/reset-password?token='.$token.'&email='.$email])
    Ingresar
@endcomponent

Gracias!!!<br>
 
@endcomponent
