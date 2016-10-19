// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {TipoEmpresaService} from "../../services/tipo_Empresa/tipoEmpresa.service";
import {CiudadanoService} from "../../services/ciudadano/ciudadano.service";
import {MunicipioService} from '../../services/municipio/municipio.service';
import {DepartamentoService} from '../../services/departamento/departamento.service';
import {EmpresaService} from "../../services/empresa/empresa.service";
import {Empresa} from '../../model/empresa/Empresa';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'registerEmpresa',
    templateUrl: 'app/view/empresa/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,EmpresaService,MunicipioService,TipoEmpresaService,CiudadanoService,DepartamentoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewEmpresaComponent {
	public empresa: Empresa;
	public errorMessage;
	public respuesta;
	public municipios;
	public tiposEmpresa;
	public ciudadano;
	public departamentos;
	public departamento;
	public habilitar = true;
	public calseCedula;
	public claseSpanCedula;
	public validateCedula = false;

	constructor(
		private _CiudadanoService: CiudadanoService,
		private _TipoEmpresaService: TipoEmpresaService,
		private _MunicipioService: MunicipioService,
		private _DepartamentoService: DepartamentoService,	
		private _EmpresaService:EmpresaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	onChange(departamentoValue) {

	this.departamento ={
			"departamentoId":departamentoValue,
	};
    let token = this._loginService.getToken();
    this._MunicipioService.getMunicipiosDep(this.departamento,token).subscribe(
				response => {
					this.municipios = response.data;
					this.empresa.municipioId=this.municipios[0].id;
					this.habilitar=false;
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

	onKeyCiudadano(event:any) {
 	let token = this._loginService.getToken();
 	let values = event.target.value;
 	let ciudadano = {
 		'numeroIdentificacion' : values,
 	};
 	this._CiudadanoService.showCiudadanoCedula(token,ciudadano).subscribe(
				response => {
					this.ciudadano = response.data;
					let status = response.status;
					if(status == 'error') {
						this.validateCedula=false;
						this.claseSpanCedula ="glyphicon glyphicon-remove form-control-feedback";
						this.calseCedula = "form-group has-error has-feedback";
					}else{
						this.validateCedula=true;
						this.claseSpanCedula ="glyphicon glyphicon-ok form-control-feedback";
						this.calseCedula = "form-group has-success has-feedback";
					}
					
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


	

	ngOnInit(){
		this.empresa = new Empresa(null,null,null,null,null,"","","","");
		let token = this._loginService.getToken();
		
		this._DepartamentoService.getDepartamento().subscribe(
				response => {
					this.departamentos = response.data;
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
	}

	onSubmit(){
		let token = this._loginService.getToken();
		this._EmpresaService.register(this.empresa,token).subscribe(
			response => {
				this.respuesta = response;
				if(this.respuesta.status=="success") {
					this.empresa = new Empresa(null,null,null,null,null,"","","","");
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
