<template>
  <div class="hello">
    <div class="container-flex-no-shadow">
      <div class="entorno-header">

        <b-progress :max="100" height="2.5rem" :variant="variantJogador">
          <b-progress-bar :value="vidaJogador">
            <span>Vida: <strong>{{vidaJogador}}</strong></span>
          </b-progress-bar>
        </b-progress>
        <b-progress :max="100" height="0.7rem" class="w-100" :animated="this.mostrarLog">
          <b-progress-bar :value="staminaJogador">
   
            <!-- <span> <strong>100</strong></span> -->
          </b-progress-bar>
        </b-progress>
        <h1 v-if="personagem" class="text-left">{{ personagem }} </h1>
        <h1 v-else class="text-left">{{ personagem }}Jogador</h1>

      </div>

      <div class="entorno-header">

        <b-progress :max="100" height="2.5rem" :variant="variantMonstro">
          <b-progress-bar :value="vidaMonstro">
            <span>Vida: <strong>{{vidaMonstro}}</strong></span>
          </b-progress-bar>
        </b-progress>
        <h1 class="text-right">Inimigo</h1>
      </div>
    </div>
    <br>

   


    <div class="lista" style="background-color: #F6F7F9">
      <transition name="fade-out">
      <div v-show="instrucoes" class="instrucoes">
        <h1>Instruções</h1>
        <br>
        <div>
          <span>Olá, todo o projeto foi desenvolvido utilizando o framework Vue.js, isto é apenas um conceito de reatividade.<br>
          </span><h5>Você deve atacar o <b>inimigo</b> antes que ele te ataque, mas pra isso, você precisa saber que: </h5>
        </div>
        <br>
        <div class="entorno-btn container-flex-3">
          <b-button disabled variant="danger">
            <b-icon icon="joystick" font-scale="1"></b-icon>  ATAQUE
          </b-button>
          <p>Use para causar <b>dano</b> ao <b>Inimigo</b>, mas lembre-se, o inimigo é mais forte que você, <br>é provável que você leve a pior. *Toda ação gera uma reação.</p>
        </div>

        <div class="entorno-btn container-flex-3">
          <b-button disabled variant="warning">
            <b-icon icon="lightning-fill" font-scale="1"></b-icon> ATAQUE ESPECIAL
          </b-button>
          <p>Use para causar <b>dano extra</b> ao <b>Inimigo</b>, consome uma fração da sua barra de <b>Energia.</b><br> *A Energia se regenera automaticamente.</p>
        </div>

        <div class="entorno-btn container-flex-3">
          <b-button disabled variant="success">
            <b-icon icon="heart-fill" font-scale="1"></b-icon> CURAR
          </b-button>
          <p>Use para <b>Recuperar</b> uma fração aleatória de vida, você possui um total de 3 curas.<br>*Toda ação gera uma reação.</p>
        </div>

      </div>
      </transition>
    
    <!-- AQUI -->
    <div class="container-flex-2">

        <div v-show="iniciar" @click="iniciarGame()" style="width: 100%; display: flex; justify-content: center; gap: 5%">
          <b-button variant="success" style="height: 100px; width: 280px;">
            <b style="font-size: 22px">INICIAR</b>
          </b-button>
        </div>  
          
        
        <div v-show="iniciar" style="width: 100%; display: flex; justify-content: center; gap: 5%">
          <b-button variant="warning" style="height: 100px; width: 180px">
            <router-link to="/leaderboards"><b-icon icon="trophy-fill" font-scale="3"></b-icon> </router-link>
          </b-button>
        </div>



        <transition name="fade">
        <div v-show="!iniciar" class="entorno-btn container-flex-btn" >

          <!-- Botão ATAQUE -->
          <b-button class="button" variant="danger" @click="ataque({jogadorMin: 3, jogadorMax: 8, monstroMin: 5, monstroMax: 14})">
            <b-icon icon="joystick" font-scale="1" animation="fadeREMOVER"></b-icon> ATAQUE
          </b-button>

          <!-- Botão ATAQUE ESPECIAL -->
          <b-button class="button" :disabled="this.disable" variant="warning" @click="ataqueEspecial({jogadorMin: 12, jogadorMax: 24, monstroMin: 3, monstroMax: 7})">
            <b-icon icon="lightning-fill" font-scale="1" animation="fadeREMOVER"></b-icon> ATAQUE ESPECIAL
          </b-button>

          <!-- Botão CURA -->
          <b-button class="button" :class="{disabled: curaActive}"  variant="success" @click="curar({curaMin: 10, curaMax: 26,monstroMin: 7, monstroMax: 15})">
            <b-icon icon="heart-fill" font-scale="1" animation="fadeREMOVER"></b-icon> CURAR<sup><span>({{curaRestantes}})</span></sup>
          </b-button>

        </div>
        </transition>
    </div>

    <div v-show="mostrarLog">
    <ul v-for="(log , i) in log.slice().reverse()" :key="i" >
      <li v-if="log[1] !== 0" class="odd"><b-icon icon="person-fill" font-scale="1"></b-icon> <b style="color: blue">Jogador</b> Atingiu <b style="color: red">Inimigo</b> com: <b>+{{log[1]}}</b></li>

      <li  v-if="log[0] !== 0" class="even"><b-icon icon="emoji-angry-fill" font-scale="1"></b-icon> <b style="color: red">Inimigo</b> Atingiu <b style="color: blue">Jogador</b> com: <b>+{{log[0]}}</b> </li>

      <li class="cura" v-if="log[2] != 0"><b-icon icon="heart-fill" font-scale="1"></b-icon> <b style="color: blue">Jogador</b> Recuperou <b>+{{log[2]}}</b> de Vida</li>
      <li class="especial" v-if="log[3] != 0"><b-icon icon="lightning-fill" font-scale="1"></b-icon> <b style="color: blue">Jogador</b> Usou Ataque Especial: <b>+{{log[3]}}</b></li>
      <br>
    </ul>
    </div>

  </div>

    
  </div>
</template>

<script>
import { bus } from '../main'; 
import Swal from 'sweetalert2';
export default {
  name: 'Principal',
  components: {
  },
  data() {
    return {
      value: 100,
      variantJogador: "success",
      variantMonstro: "success",
      iniciar: true,
      disable: false,
      curaActive: false,
      instrucoes: true,
      vidaJogador: 100,
      vidaMonstro: 100,
      staminaJogador: 100,
      danoNoJogador: 0,
      danoNoMonstro: 0,
      curaJogador: 0,
      curaRestantes: 3,
      personagem: "Jogador",
      password: "",
      mostrarLog: false,
      resultado: "",
      idIntervalIniciarGame: 0,
      log: [],
      grupoLog: [] 
      // logs: [{ "Jogador": [], "Monstro": [], "Cura": [] }]
    }
  },
  methods: {
    verificaVariantJogador(variant) {
      if (this.vidaJogador <= 20) {
       return this.variantJogador = "danger";  
      } else if (this.vidaJogador <= 81) {
       return this.variantJogador = "warning"; 
      } else if (this.vidaJogador > 81) {
        return this.variantJogador = "success";
      } 
      return variant;
    },

    verificaVariantMonstro(variant) {
      if (this.vidaMonstro <= 20) {
       return this.variantMonstro = "danger";  
      } else if (this.vidaMonstro <= 81) {
       return this.variantMonstro = "warning"; 
      } else if (this.vidaMonstro > 81) {
        return this.variantMonstro = "success";
      } 
      return variant;
    },

    iniciarGame() {
     
      

      document.getElementById('b-modal').click();

      this.mostrarLog = true;
      this.iniciar = false;
      this.instrucoes = false;

      this.personagem = "";
      
    },

    ataque(pontosAtaque) {

      navigator.vibrate(50);

     setTimeout(() => {
      this.danoNoJogador = Math.floor(Math.random() * (pontosAtaque.monstroMax - pontosAtaque.monstroMin + 1)) + pontosAtaque.monstroMin;
      this.vidaJogador -= this.danoNoJogador;
     }, 100);


    setTimeout(() => {
      this.danoNoMonstro = Math.floor(Math.random() * (pontosAtaque.jogadorMax - pontosAtaque.jogadorMin + 1)) + pontosAtaque.jogadorMin;
      this.vidaMonstro -=  this.danoNoMonstro;
      }, 10);

  setTimeout(() => {
      this.grupoLog = [this.danoNoJogador,this.danoNoMonstro,0,0];
      this.log.push(this.grupoLog);
        }, 150);
     
    },

    ataqueEspecial(pontosAtaque) {
      navigator.vibrate(50);
      let timerInterval
      Swal.fire({
        title: '',
        html: '',
        showConfirmButton: false,
        allowOutsideClick: false,
        imageUrl: 'http://68.media.tumblr.com/fa2b4c3f34d71afd8dc59ab9a8bb28f0/tumblr_n349irFbbZ1ruoznzo1_500.gif',
        imageWidth: 500,
        imageHeight: 300,
        timer: 2800,
        backdrop: `
            rgba(0,0,0,0.9)
            center top
            no-repeat
          `,
        timerProgressBar: false,
        didOpen: () => {
          // Swal.showLoading()
          const b = Swal.getHtmlContainer().querySelector('b')
          timerInterval = setInterval(() => {
            b.textContent = Swal.getTimerLeft()
          }, 100)
        },
        willClose: () => {
          clearInterval(timerInterval)
        }
      }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
          return result;
        }
      })


      clearInterval(this.idIntervalIniciarGame);
      setTimeout(() => {

       
        
        this.disable = true;
        this.staminaJogador -= 40;

        this.danoNoMonstro = Math.floor(Math.random() * (pontosAtaque.jogadorMax - pontosAtaque.jogadorMin + 1)) + pontosAtaque.jogadorMin;
        this.vidaMonstro -=  this.danoNoMonstro;

        if (this.staminaJogador >= 40) {
            this.disable = false;
          }

        this.grupoLog = [0,0,0,this.danoNoMonstro];
        this.log.push(this.grupoLog);

        // this.iniciarGame();
          this.idIntervalIniciarGame = setInterval(() => {
            // console.log("Inimigo esta atacando Automaticamente");
            this.monstroAtaque({jogadorMin: 0, jogadorMax: 0, monstroMin: 5, monstroMax: 10});
          }, 8000);

      }, 2900);

    },
    curar(pontosCura) {
      navigator.vibrate(50);
      this.danoNoJogador = Math.floor(Math.random() * (pontosCura.monstroMax - pontosCura.monstroMin + 1)) + pontosCura.monstroMin;
      console.log("Recebeu de Dano: "+this.danoNoJogador);
      this.vidaJogador -= this.danoNoJogador;

      this.curaJogador = Math.floor(Math.random() * (pontosCura.curaMax - pontosCura.curaMin + 1)) + pontosCura.curaMin;
      this.vidaJogador += this.curaJogador;
      console.log("Cura Recebida: "+this.curaJogador);

      // this.cura.push(this.curaJogador);
      this.grupoLog = [this.danoNoJogador,0,this.curaJogador,0];
      this.log.push(this.grupoLog);

      if (this.vidaJogador > 100) {
        this.vidaJogador = 100;
      }

      // Lógica da contabilização da cura
      this.curaRestantes --;
      if (this.curaRestantes == 0) {
        this.curaActive = true;
      }
      
    },

    monstroAtaque(pontosAtaque) {

      this.danoNoJogador = Math.floor(Math.random() * (pontosAtaque.monstroMax - pontosAtaque.monstroMin + 1)) + pontosAtaque.monstroMin;
      this.vidaJogador -= this.danoNoJogador;

      this.grupoLog = [this.danoNoJogador,0,0,0];
      this.log.push(this.grupoLog);

    },

    resetGame() {
      this.variantJogador = "success";
      this.variantMonstro = "success";
      this.iniciar = true;
      this.vidaJogador = 100;
      this.vidaMonstro = 100;
      this.danoNoJogador = 0;
      this.danoNoMonstro = 0;
      this.resultado = "";
      this.logs = []
    },

    escolherClass(log) {
      if (log % 2 == 0) {return ['odd','Jogador','Inimigo']} else {return ['even','Inimigo','Jogador']}
    }
  },
  watch: {
    personagem() {
      bus.$on('submit', ([nome, password]) => {
        this.personagem = "Jogador"
        this.personagem = nome;
        this.password = "Password";
        this.password = password;


        this.idIntervalIniciarGame = setInterval(() => {
        // console.log("Inimigo esta no modo automatico");
        this.monstroAtaque({jogadorMin: 0, jogadorMax: 0, monstroMin: 5, monstroMax: 10});
      }, 10000);

      });


        



    },
    vidaJogador() {
      this.verificaVariantJogador(this.variantJogador);
      // console.log("JOGADOR life 0");
      if (this.vidaMonstro < 0 && this.vidaJogador != 0){
        this.vidaMonstro = 0;
        this.resultado = true;
        return;
      }
      else if (this.vidaJogador < 0 && this.vidaMonstro != 0) {
        this.vidaJogador = 0;
        this.resultado = false;
        return;
      }
    },
    vidaMonstro() {
      this.verificaVariantMonstro(this.variantMonstro);
      if (this.vidaMonstro < 0 && this.vidaJogador != 0){
        this.vidaMonstro = 0;
        this.resultado = true;
        return;
      }
      else if (this.vidaJogador < 0 && this.vidaMonstro != 0) {
        this.vidaJogador = 0;
        this.resultado = false;
        return;
      }
      // if (this.vidaMonstro < 0) {
        
      // }
    },
    resultado() {
      // GANHOU
      this.iniciar = false;
      this.mostrarLog = false;
      clearInterval(this.idIntervalIniciarGame);

      
        
      
      if (this.resultado === true) {
        setTimeout(() => {
        Swal.fire({
          showConfirmButton: false,
          allowOutsideClick: false,
          showClass: {
            popup: 'animate__animated animate__fadeInDown'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
          },
          title: 'You Win',
          text: 'Sempre em busca do mais forte!',
          html: '<p>Sempre em busca do mais forte!</p><p>Você agora faz parte do nosso ranking dos lutadores.</p>',
            // '<a href="//sweetalert2.github.io">links</a> ' +
            // 'and other HTML tags',
          imageUrl: 'https://www.fightersgeneration.com/characters3/ryu-big-intro-gif.gif',
          imageWidth: 250,
          imageHeight: 200,
          imageAlt: 'You Lose',
          backdrop: `
            rgba(0,0,0,0.9)
            center top
            no-repeat
          `,
        })

        // FAZER O FECTH DA VITORIA AQUI
        fetch('https://brauliomateus.com/todata/post.php',{
          method: "POST",
          body: JSON.stringify({
              nome: this.personagem,
              password: this.password,
              vitoria: 1,
              derrota: 0,
              vida: this.vidaJogador
          }),
          }).then(response => {
              console.log(response);
            })
            .catch(error => {
                console.log(error);
            })
        
            }, 1100);
        // PERDEU
        } 
          
        else if (this.resultado === false) {
        this.iniciar = false;
        this.mostrarLog = false;
        clearInterval(this.idIntervalIniciarGame);
        Swal.fire({
          showConfirmButton: false,
          allowOutsideClick: false,
          text: 'GAME OVER',
          imageUrl: 'https://www.fightersgeneration.com/characters3/ryu-hurt.gif',
          imageWidth: 180,
          imageHeight: 200,
          imageAlt: 'You Lose',
          backdrop: `
            rgba(0,0,0,0.9)
            center top
            no-repeat
          `,
        })

        // FAZER O FECTH DA DERROTA AQUI
        fetch('https://brauliomateus.com/todata/post.php',{
          // Adding method type
          method: "POST",
          // Adding body or contents to send
          body: JSON.stringify({
              nome: this.personagem,
              password: this.password,
              vitoria: 0,
              derrota: 1,
              vida: this.vidaJogador
          }),
          }).then(response => {
              console.log(response);
            })
            .catch(error => {
                console.log(error);
            })



      }

        
          

    }
  },
  created() {
    setInterval(() => {
      if (this.staminaJogador <= 40) {
        this.disable = true;
        this.staminaJogador+=1.5;
      } else if (this.staminaJogador > 40 && this.staminaJogador <=100) {
        this.disable = false;
        this.staminaJogador+=1.5;
      }
    }, 1000);
  },
  mounted() {
    // Ativador da Diretiva Watch
    // this.personagem = this.$store.state.nome.nome;
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

a {
 color: #000 !important;
}
h3 {
  margin: 40px 0 0;
}
p {
  margin: 10px 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
.cura {
  display: block;
  margin: 10px;
  padding: 10px 0;
  color: #fff;
  background-color: green;
}
.especial {
  display: block;
  margin: 10px;
  padding: 10px 0;
  color: #000;
  background-color: #FFC107;
}
.odd {
  display: block;
  margin: 10px;
  padding: 10px 0;
  color: #fff;
  background-color: #E37778;
}
.even {
  display: block;
  margin: 10px;
  padding: 10px 0;
  color: #fff;
  background-color: #848DC7;
}
a {
  color: #42b983;
}
.container-flex {
  display: flex;
  justify-content: space-evenly;
  flex-wrap: wrap;
  box-shadow: 0px 0px 5px 0px rgba(0,0,0, 0.2);
}
.container-flex-no-shadow {
  display: flex;
  justify-content: space-evenly;
  flex-wrap: wrap;
}
.container-flex-2 {
  display: flex;
  justify-content: center;
  gap: 15px;
  flex-wrap: wrap;
  box-shadow: 0px 0px 5px 0px rgba(0,0,0, 0.2);
  padding: 15px 0;
}
.container-flex-3 {
  display: flex;
  justify-content: center;
  align-items: baseline;
  gap: 25px;
  flex-wrap: wrap;
  /* box-shadow: 0px 0px 5px 0px rgba(0,0,0, 0.2); */
  padding: 15px 0;
}
.lista {
  box-shadow: 0px 0px 5px 0px rgba(0,0,0, 0.2);
  padding: 15px 0;
}
.entorno {
  width: 40%;
  padding: 25px;
}
.entorno-header {
  width: 38%;
  /* width: 30%; */
}
.entorno-btn {
  width: 100%;
  padding: 25px;
}
.container-flex-btn {
  display: flex;
  justify-content: center;
  gap: 25px
}

.text-left {
  text-align: left;
}

.text-right {
  text-align: right;
}



@media (min-width: 426px)
{
  .button {
    width: 200px;
    height: 75px;
  }
}

.hello {
  /* margin-top: -40px */
}



.fade-enter-active, .fade-leave-active {
  transition: opacity 6s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

.fade-out-enter-active, .fade-out-leave-active {
  transition: opacity 0.7s;
}
.fade-out-enter, .fade-out-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}



</style>
