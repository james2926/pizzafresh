<template>

    <v-app id="inspire">
        <v-content >
            <v-container class="fill-height background-img" fluid >

                <v-row align="center" justify="center">
                    <v-col cols="12" md="6" lg="4">

                        
                        <v-card style="border-radius:5px;padding:0;" flat class="elevation-2">
                            <div style="padding:2.5rem;">
                                                        <img width="100%;" src="logo.png" alt="">

                                
                                    <h1 style=" text-align: center;color:grey">Olvide Contraseña</h1>
                            
                                <v-card-text>
                                    <v-form>
                                        <v-text-field prepend-icon="mdi-account" v-model="user.email" label="Email" required></v-text-field>
                                    
                                    </v-form>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn :disabled="isloading" @click="Login" color="blue" style="min-width:100% !important;border-radius:5px !important" class="white--text">Recuperar</v-btn>
                                    
                                </v-card-actions>
                                <v-spacer></v-spacer>
                                    <router-link to="/login">
                                    Iniciar Sesion
                                    </router-link>
                            </div>
                            
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>


</template>

<script>
    import auth from '../../auth/auth.js'
    export default {
        data() {
            return {
                show1: false,
                user: {
                    email: '',
               
                }
            }
        },
        methods: {
            Login() {
               axios.post("/api/forgot-password", {
                    email: this.user.email
                }).then(function (res) {
                   
                    window.location = "/";
                }, function (err) {
                    _this.$custom_error(error.response.data.message);
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