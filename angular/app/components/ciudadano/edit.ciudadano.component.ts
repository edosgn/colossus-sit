// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TipoIdentificacionService} from '../../services/tipo_Identificacion/tipoIdentificacion.service';
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";
import {Ciudadano} from '../../model/ciudadano/Ciudadano';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/ciudadano/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,CiudadanoService,TipoIdentificacionService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class CiudadanoEditComponent implements OnInit{ 
	public errorMessage;
	public ciudadano : Ciudadano;
	public id;
	public respuesta;
	public tiposIdentificacion;

	constructor(
		private _TipoIdentificacionService:TipoIdentificacionService,
		private _loginService: LoginService,
		private _CiudadanoService: CiudadanoService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.ciudadano = new Ciudadano(null,"",null, "","","","","");

		let token = this._loginService.getToken();
		this._TipoIdentificacionService.getTipoIdentificacion().subscribe(
				response => {
					this.tiposIdentificacion = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);

				this._route.params.subscribe(params =>{
					this.id = +params["id"];
				});

			this._CiudadanoService.showCiudadano(token,this.id).subscribe(

						response => {
							let data = response.data;
							console.log(data);
							this.ciudadano = new Ciudadano(
								data.id,
								data.tipoIdentificacion.id, 
								data.numeroIdentificacion, 
								data.nombres,
								data.apellidos,
								data.direccion,
								data.telefono,
								data.correo
								);
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
		this._CiudadanoService.editCiudadano(this.ciudadano,token).subscribe(
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





