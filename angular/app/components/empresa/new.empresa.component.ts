// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TipoEmpresaService} from "../../services/tipo_Empresa/tipoEmpresa.service";
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";
import {MunicipioService} from '../../services/municipio/municipio.service';
import {EmpresaService} from "../../services/empresa/empresa.service";
import {Empresa} from '../../model/empresa/Empresa';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/empresa/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,EmpresaService,MunicipioService,TipoEmpresaService,CiudadanoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewEmpresaComponent {
	public empresa: Empresa;
	public errorMessage;
	public respuesta;
	public municipios;
	public tiposEmpresa;
	public ciudadanos;

	constructor(
		private _CiudadanoService: CiudadanoService,
		private _TipoEmpresaService: TipoEmpresaService,
		private _MunicipioService: MunicipioService,	
		private _EmpresaService:EmpresaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.empresa = new Empresa(null,null,null,null,null,"","","","");
		let token = this._loginService.getToken();
		
		this._MunicipioService.getMunicipio().subscribe(
				response => {
					this.municipios = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this._TipoEmpresaService.getTipoEmpresa().subscribe(
				response => {
					this.tiposEmpresa = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this._CiudadanoService.getCiudadano().subscribe(
				response => {
					this.ciudadanos = response.data;
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
		this._EmpresaService.register(this.empresa,token).subscribe(
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
