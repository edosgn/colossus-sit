// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TipoIdentificacionService} from '../../services/tipo_Identificacion/tipoIdentificacion.service';
import {TipoIdentificacion} from '../../model/tipo_Identificacion/TipoIdentificacion';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/tipo_Identificacion/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,TipoIdentificacionService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTipoIdentificacionComponent {
	public tipoIdentificacion: TipoIdentificacion;
	public errorMessage;
	public respuesta;

	constructor(
		private _TipoIdentificacionService:TipoIdentificacionService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.tipoIdentificacion = new TipoIdentificacion(null, "");
	}

	onSubmit(){
		let token = this._loginService.getToken();
		this._TipoIdentificacionService.register(this.tipoIdentificacion,token).subscribe(
			response => {
				this.respuesta = response;
				console.log(this.respuesta);

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
