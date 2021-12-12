<template>
    <div>
        <div class="mb-1" style="display:none">
            <b-button id="b-modal" @click="modalInput"></b-button>
        </div>
         
  </div>


     
</template>

<script>
import Swal from 'sweetalert2';
import { bus } from '../main';

export default {
    name: 'Modal',
    components: {
    },
    data() {
      return {
        nome: '',
        boxTwo: '',
        password: '',
        params: {data1: 'string'},
        headers: {"Authorization": "Bearer my-token","My-Custom-Header": "foobar", "responseType":"json",'Access-Control-Allow-Origin' : '*','Access-Control-Allow-Methods':'GET,PUT,POST,DELETE,PATCH,OPTIONS','Access-Control-Allow-Credentials':true} 
      }
    },
    methods: {
        
   getPassword() {
      var chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJLMNOPQRSTUVWXYZ";
      var passwordLength = 10;
      var password = "";

      for (var i = 0; i < passwordLength; i++) {
        var randomNumber = Math.floor(Math.random() * chars.length);
        password += chars.substring(randomNumber, randomNumber + 1);
      }
      return password;
    },



    modalInput() {
    Swal.fire({
    title: 'Calma...',
    icon: 'info',
    showClass: {
      popup: 'animate__animated animate__fadeInDown'
    },
    hideClass: {
      popup: 'animate__animated animate__fadeOutUp'
    },
    allowOutsideClick: false,
    backdrop: `
        rgba(0,0,0,0.9)
        url("https://www.fightersgeneration.com/characters3/ryu-big-intro-gif.gif")
        center top
        no-repeat
        `,
    html:
        'Precisamos saber com quem estamos lutando.<br>' +
        'Qual o seu nome?' +
        '',
    input: 'text',
    inputAutoTrim: true,
    inputAttributes: {
    autocapitalize: 'on',
    required: 'true',
    maxlength: 15
    },
    showCancelButton: false,
    confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
    showLoaderOnConfirm: true,
    preConfirm: (nome) => {
    
    return fetch('https://brauliomateus.com/todata/post.php',{
    method: "POST",
    body: JSON.stringify({
        nome: nome,
        password: this.password,
        vitoria: 0,
        derrota: 0
    }),
    }
    ).then(response => {
        this.nome = nome;
        bus.$emit('submit', [this.nome, this.password]);
        return response.json()
      })
      .catch(error => {
          console.log(error)
        })
      },
    })


      }
        },


    created() {
        this.password = this.getPassword();
    }
            }
    
    
</script>

<style>

</style>