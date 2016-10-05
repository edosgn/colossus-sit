// Importar el núcleo de Angular
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import {MarcaService} from '../../services/marca/marca.service';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Marca} from '../../model/marca/marca';
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/marca/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,MarcaService]]
})
 
// combustible del componente donde irán los datos y funcionalidades
export class MarcaEditComponent implements OnInit{ 
	public errorMessage;
	public marca : Marca;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _MarcaService:MarcaService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.marca = new Marca(null, "",null);
		let token = this._loginService.getToken();
			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});
			this._MarcaService.showMarca(token,this.id).subscribe(

						response => {
							this.marca = response.data;
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
		this._MarcaService.editMarca(this.marca,token).subscribe(
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





