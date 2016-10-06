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
    selector: 'default',
    templateUrl: 'app/view/empresa/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,CiudadanoService,EmpresaService,MunicipioService,TipoEmpresaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class EmpresaEditComponent implements OnInit{ 
	public errorMessage;
	public empresa: Empresa;
	public id;
	public respuesta;
	public tiposIdentificacion;
	public municipios;
	public tiposEmpresa;
	public ciudadanos;

	constructor(
		private _TipoEmpresaService: TipoEmpresaService,
		private _MunicipioService: MunicipioService,
		private _EmpresaService:EmpresaService,
		private _loginService: LoginService,
		private _CiudadanoService: CiudadanoService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		this.empresa = new Empresa(null,null,null,null,null,"","","","");

		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._EmpresaService.showEmpresa(token,this.id).subscribe(

						response => {
							let data = response.data;
							console.log(data);
							this.empresa = new Empresa(
								data.id,
								data.municipio.id, 
								data.tipoEmpresa.id, 
								data.ciudadano.id,
								data.nit,
								data.nombre,
								data.direccion,
								data.telefono,
								data.correo
								);
							console.log(this.empresa);
						},
						error => {
								this.errorMessage = <any>error;

								if(this.errorMessage != null){
									console.log(this.errorMessage);
									alert("Error en la petición");
								}
							}

					);

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
		this._EmpresaService.editEmpresa(this.empresa,token).subscribe(
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





