// Importar el núcleo de Angular
import {Component, OnInit,Input,Output,EventEmitter} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TipoIdentificacionService} from '../../services/tipo_Identificacion/tipoIdentificacion.service';
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";
import {Ciudadano} from '../../model/ciudadano/Ciudadano';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'registerCiudadano',
    templateUrl: 'app/view/ciudadano/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,CiudadanoService,TipoIdentificacionService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewCiudadanoComponent {
	public ciudadano: Ciudadano;
	public errorMessage;
	public respuesta;
	public tiposIdentificacion;
	@Input() identificacionIngresada; 
	@Output() ciudadanoCreado = new EventEmitter<any>();

	constructor(
		private _TipoIdentificacionService: TipoIdentificacionService,	
		private _CiudadanoService:CiudadanoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){
}

	ngOnInit(){
		
		this.ciudadano = new Ciudadano(null,"",this.identificacionIngresada, "","","","","");
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
	}

	onSubmit(){
		let token = this._loginService.getToken();
		this._CiudadanoService.register(this.ciudadano,token).subscribe(
			response => {
				this.respuesta = response;
				if(this.respuesta.status=="success"){
					this.ciudadanoCreado.emit(this.ciudadano.numeroIdentificacion);
				}

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
