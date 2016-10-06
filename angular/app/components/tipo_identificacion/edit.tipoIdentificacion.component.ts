// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TipoIdentificacionService} from '../../services/tipo_Identificacion/tipoIdentificacion.service';
import {TipoIdentificacion} from '../../model/tipo_Identificacion/TipoIdentificacion';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/Tipo_Identificacion/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,TipoIdentificacionService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class TipoIdentificacionEditComponent implements OnInit{ 
	public errorMessage;
	public tipoIdentificacion : TipoIdentificacion;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _TipoIdentificacionService: TipoIdentificacionService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.tipoIdentificacion = new TipoIdentificacion(null,"");


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._TipoIdentificacionService.showTipoIdentificacion(token,this.id).subscribe(

						response => {
							this.tipoIdentificacion = response.data;
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
		this._TipoIdentificacionService.editTipoIdentificacion(this.tipoIdentificacion,token).subscribe(
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





