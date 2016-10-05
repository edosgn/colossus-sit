// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {BancoService} from '../../services/banco/banco.service';
import {Banco} from '../../model/banco/Banco';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/banco/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,BancoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class BancoEditComponent implements OnInit{ 
	public errorMessage;
	public banco : Banco;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _BancoService: BancoService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.banco = new Banco(null,"");


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._BancoService.showBanco(token,this.id).subscribe(

						response => {
							this.banco = response.data;
						},
						error => {
								this.errorMessage = <any>error;

								if(this.errorMessage != null){
									console.log(this.errorMessage);
									alert("Error en la petición");
								}
							}

					);
	  
	} 


	onSubmit(){
		let token = this._loginService.getToken();
		this._BancoService.editBanco(this.banco,token).subscribe(
			response => {
				this.respuesta = response;
			error => {
					this.errorMessage = <any>error;
					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}

		});
	}


}





