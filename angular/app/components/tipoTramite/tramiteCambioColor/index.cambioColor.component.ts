// Importar el núcleo de Angular
import {LoginService} from "../../../services/login.service";
import {Component, OnInit,Input} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {ColorService} from "../../../services/color/color.service";
import {TramiteEspecificoService} from "../../../services/tramiteEspecifico/tramiteEspecifico.service";
import {TramiteEspecifico} from '../../../model/tramiteEspecifico/TramiteEspecifico';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'color',
    templateUrl: 'app/view/tipoTramite/cambioColor/index.component.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ColorService,TramiteEspecificoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class IndexCambioColorComponent implements OnInit{ 
	
	public colores;
	public errorMessage;
	public tramiteGeneralId= 22;
	public valor;
	public tramiteEspecifico;
	public respuesta;
	@Input() vehiculo = null;
	public datos = {
		'nuevo':null,
		'viejo':null
	};
	constructor(
		
		private _TramiteEspecificoService: TramiteEspecificoService, 
		private _loginService: LoginService,
		private _ColorService: ColorService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){

	}


	ngOnInit(){


		this.tramiteEspecifico = new TramiteEspecifico(null,5,this.tramiteGeneralId,null,null,null);
		this._ColorService.getColor().subscribe(
				response => {
					this.colores = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this.datos.viejo=this.vehiculo.color.nombre;

	}



	onChangeColor(event:any){
		this.datos.nuevo=event;
		console.log(this.datos);
		console.log(this.tramiteEspecifico);
	}

	enviarTramite(){
		let token = this._loginService.getToken();
		this._TramiteEspecificoService.register(this.tramiteEspecifico,token).subscribe(
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
