<template>

    <v-app id="inspire">
        <v-content >
            <v-container class="fill-height background-img" fluid >

                <v-row align="center" justify="center">
                    <v-col cols="12" md="6" lg="4">

                        
                        <v-card style="border-radius:5px;padding:0;" flat class="elevation-2">
                            <div style="padding:2.5rem;">
                                                        <img width="100%;" src="logo.png" alt="">

                                
                                    <h1 style=" text-align: center;color:grey">Escriba nueva Contraseña</h1>
                            
                                <v-card-text>
                                    <v-form>
                                        <v-text-field prepend-icon="mdi-account" disabled v-model="user.email" label="Email" required></v-text-field>
                                        <v-text-field   prepend-icon="mdi-key" v-model="user.password" label="Contraseña" required type="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'"
                                        @click:append="show1 = !show1" autocomplete="new-password"></v-text-field>
                                        <v-text-field  prepend-icon="mdi-key" v-model="user.password_confirmation" label="Confirmar Contraseña" required type="password" :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'" :type="show2 ? 'text' : 'password'"
                                        @click:append="show2 = !show2" autocomplete="new-password"></v-text-field>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn :disabled="isloading" @click="Login" color="blue" style="min-width:100% !important;border-radius:5px !important" class="white--text">Recuperar</v-btn>
                                    
                                </v-card-actions>
                                <v-spacer></v-spacer>
                                  
                            </div>
                            
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>


</template>

<script>
  
    export default {
        data() {
            return {
                
                email:'',
                show1: false,
                show2: false,
                user: {
                    token:'',
                    email: '',
                    password: '',
                    password_confirmation:''
               
                }
            }
        },
        created() {
            
            if (this.$route.query.token) {
                this.user.token =this.$route.query.token;
                if(this.$route.query.email){
                    this.user.email = this.$route.query.email;
                }
            }
            else{
                alert('token invalido');
                window.location = "/";
            }
        },
        methods: {
          
            Login() {
                  let eso = this;
               axios.post("/update-password",this.user).then(function (res) {
                   if(res.data !='passwords.reset'){
                        eso.$custom_error("La sesion ha expirado, debe volver a pedir un cambio de contraseña");

                    }
                    else{
                                           window.location = "/";

                    }
                }, function (err) {
                    
                    if(err.response.data.errors !=null){
                        if(err.response.data.errors.password !=null){
                                                    
                                                    eso.$custom_error("Las contraseñas no coinciden");

                        }
                        else if(err.response.data.errors.reset !=null){
                                                    
                                                   window.location = "/";

                        }{
                                                eso.$custom_error("error desconocido");

                        }

                    }
                    else{
                                                                        eso.$custom_error("Error de red");

                    }

                });
            }
        },
        computed: {
            isloading: function() {
            },
        }
    }
</script>

<style>
    .background-img{
         background-image: url("https://cerramientoscandela.com/wp-content/uploads/P%C3%A9rgolas-bioclim%C3%A1ticas-de-Cerramientos-Candela-en-Elche-para-toda-la-provincia-de-Alicante-y-Murcia-10.jpg");
         background-size: cover;
    }
        .background-img:before {
  content: ' ';
  display: block;
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  opacity: 0.7;
  background-color: #000000}
    .cover-img {
        height: 100%
    }

    .back {
        background-color: #212121;
        
    }
</style>