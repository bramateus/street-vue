<template>
  <section class="main-content">
		<div class="container">
			<!-- <h1>Rank</h1> -->
			<br>
			<!-- <br> -->
			<div class="row">
				<div class="col-sm-4">
					<!-- <div class="leaderboard-card">
						<div class="leaderboard-card__top">
							<h3 class="text-center">$1,051</h3>
						</div>
						<div class="leaderboard-card__body">
							<div class="text-center">
								<img src="img/user2.jpg" class="circle-img mb-2" alt="User Img">
								<h5 class="mb-0">Sandeep Sandy</h5>
								<p class="text-muted mb-0">@sandeep</p>
								<hr>
								<div class="d-flex justify-content-between align-items-center">
									<span><i class="fa fa-map-marker"></i> Bangalore</span>
									<button class="btn btn-outline-success btn-sm">Congratulate</button>
								</div>
							</div>
						</div>
					</div> -->
				</div>
				<div class="col-sm-4">
					<div class="leaderboard-card leaderboard-card--first">
						<div class="leaderboard-card__top">
							<h3 class="text-center">Vida: {{this.dados[0].life_player}}%</h3>
						</div>
						<div class="leaderboard-card__body">
							<div class="text-center">
								<img src="https://brauliomateus.com/logo.png" class="circle-img mb-2" alt="User Img">
								<h5 class="mb-0">{{this.dados[0].nome_player}}</h5>
								<p class="text-muted mb-0">@{{this.dados[0].nome_player}}</p>
								<hr>
								<div class="d-flex justify-content-between align-items-center">
									<span><i class="fa fa-map-marker"></i> Vida Restante: <b>{{this.dados[0].life_player}}</b></span>
									<span><i class="fa fa-map-marker"></i><b>{{this.dados[0].data_player}}</b></span>
									<!-- <button class="btn btn-outline-success btn-sm">Congratulate</button> -->
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<!-- <div class="leaderboard-card">
						<div class="leaderboard-card__top">
							<h3 class="text-center">$1,012</h3>
						</div>
						<div class="leaderboard-card__body">
							<div class="text-center">
								<img src="img/user3.jpg" class="circle-img mb-2" alt="User Img">
								<h5 class="mb-0">John doe</h5>
								<p class="text-muted mb-0">@johndoe</p>
								<hr>
								<div class="d-flex justify-content-between align-items-center">
									<span><i class="fa fa-map-marker"></i> Bangalore</span>
									<button class="btn btn-outline-success btn-sm">Congratulate</button>
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>

<!-- {{this.dados[0]}} -->
			<h4 style="text-align: left">Competidores</h4><br>

			<table class="table">
				<thead>
					<tr>
						<th style="text-align: center">Posição</th>
						<th style="text-align: left">Usuário</th>
						<th style="text-align: left">Vida Restante</th>
						<th>Pais</th>
						<th>Data</th>
					</tr>
				</thead>
				<tbody>


					<tr v-for="(data , i) in dados " :key="i"> 
                        <td v-if="i != 0 && data.vitoria_player == 1">
                            <h5 class="mb-0" style="padding: 0 32px">#{{i+1}}</h5>
                        </td>
						<td v-if="i != 0 && data.vitoria_player == 1">
							<div class="d-flex align-items-center">
								<img src="https://brauliomateus.com/logo.png" class="circle-img circle-img--small mr-2" alt="User Img">
								<div class="user-info__basic" style="padding: 0 10px">
									<h5 class="mb-0">  {{data.nome_player}}</h5>
									<p class="text-muted mb-0">  @{{data.nome_player}}</p>
								</div>
							</div>
						</td>
						<td v-if="i != 0 && data.vitoria_player == 1">
							<div class="d-flex align-items-baseline">
								<h4 class="mr-1">{{data.life_player}}%</h4>
							</div>
						</td>
						<td v-if="i != 0 && data.vitoria_player == 1">Brasil</td>
						<td v-if="i != 0 && data.vitoria_player == 1">
							<p>{{data.data_player}}</p>
						</td>
					</tr>
				



				
					
				</tbody>
			</table>
		</div>
	</section>
</template>

<script>
export default {
    name: 'Leader',

    data() {
      return {
          dados: [],
      }
    },

    methods: {
        fetch() {

            fetch('https://brauliomateus.com/todata/rest/api/promocao')
                .then(r => r.json())
                .then(r => {
                    if (r[0]) {
                        this.dados = r;
                    } else {
                        console.log("Nao Possui")
                    }
                }).catch(error => {
                    console.log(error)
                    })
        }

    },

    created() {
        this.fetch();
    }



 

}
</script>

<style>
    @import url("https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap");
body {
	background: #f9f9f9;
	font-family: "Roboto", sans-serif;
}

.main-content {
	/* padding-top: 100px; */
	padding-bottom: 100px;
}

.leaderboard-card {
	background: #fff;
	margin-bottom: 30px;
	border-radius: 5px;
	overflow: hidden;
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.leaderboard-card.leaderboard-card--first {
	transform: scale(1.05);
}
.leaderboard-card.leaderboard-card--first .leaderboard-card__top {
	background: linear-gradient(45deg, #41B883, #35495E);
	/* background: linear-gradient(45deg, #FFBB13, #Edcf80); */
	/* background: linear-gradient(45deg, #7e57c2, #ab47bc); */
	color: #fff;
}
.leaderboard-card__top {
	background: #f9f6ff;
	padding: 20px 0 30px 0;
}
.leaderboard-card__body {
	padding: 15px;
	margin-top: -40px;
}

img.circle-img {
	height: 70px;
	width: 70px;
	border-radius: 70px;
	border: 3px solid #fff;
	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
img.circle-img.circle-img--small {
	height: 55px;
	width: 55px;
	border-radius: 55px;
}

.table {
	border-spacing: 0 15px;
	border-collapse: separate;
}
.table thead tr th,
.table thead tr td,
.table tbody tr th,
.table tbody tr td {
	vertical-align: middle;
	border: none;
}
.table thead tr th:nth-last-child(1),
.table thead tr td:nth-last-child(1),
.table tbody tr th:nth-last-child(1),
.table tbody tr td:nth-last-child(1) {
	text-align: center;
}
.table tbody tr {
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
	border-radius: 5px;
}
.table tbody tr td {
	background: #fff;
}
.table tbody tr td:nth-child(1) {
	border-radius: 5px 0 0 5px;
}
.table tbody tr td:nth-last-child(1) {
	border-radius: 0 5px 5px 0;
}
</style>