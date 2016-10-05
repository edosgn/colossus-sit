// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {ModuloService} from '../../services/modulo/modulo.service';
import {Modulo} from '../../model/modulo/Modulo';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/modulo/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,ModuloService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class ModuloEditComponent implements OnInit{ 
	public errorMessage;
	public modulo : Modulo;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _ModuloService: ModuloService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.modulo = new Modulo(null,"","");


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._ModuloService.showModulo(token,this.id).subscribe(

						response => {
							this.modulo = response.data;
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
		this._ModuloService.editModulo(this.modulo,token).subscribe(
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





