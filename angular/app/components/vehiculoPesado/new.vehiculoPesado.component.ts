// Importar el núcleo de Angular
import {Component, OnInit,Output,EventEmitter,Input} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {ModalidadService} from '../../services/modalidad/modalidad.service';
import {LineaService} from '../../services/linea/linea.service';
import {VehiculoService} from '../../services/vehiculo/vehiculo.service';
import {EmpresaService} from '../../services/empresa/empresa.service';
import {ClaseService} from '../../services/clase/clase.service';
import {CarroceriaService} from '../../services/carroceria/carroceria.service';
import {OrganismoTransitoService} from '../../services/organismoTransito/organismoTransito.service';
import {VehiculoPesadoService} from "../../services/vehiculopesado/vehiculopesado.service";
import {VehiculoPesado} from '../../model/vehiculopesado/VehiculoPesado';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'registrarVehiculoPesado',
    templateUrl: 'app/view/vehiculopesado/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,VehiculoPesadoService,ModalidadService,VehiculoService,EmpresaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewVehiculoPesadoComponent {
	public vehiculoPesado: VehiculoPesado;
	public errorMessage;
	public respuesta;
	public modalidades;
	public lineas;
	public vehiculos;
	public empresas;
	public combustibles;
	public carrocerias; 
	public clases;
	public organismosTransito;
	public validateCedula;
	public claseSpanCedula;	
	public claseCedula;
	public empresa;
	public divEmpresa;
	@Input() placaIngresada;
	@Output() tramiteCreado = new EventEmitter<any>();



	constructor(
		private _ModalidadService: ModalidadService,
		private _VehiculoService: VehiculoService,
		private _EmpresaService: EmpresaService,
		private _VehiculoPesadoService:VehiculoPesadoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.vehiculoPesado = new VehiculoPesado(null,null,this.placaIngresada,null,null,null,null,"","");
		console.log(this.vehiculoPesado);

		let token = this._loginService.getToken();
		this._ModalidadService.getModalidad().subscribe(
				response => {
					this.modalidades = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this._VehiculoService.getVehiculo().subscribe(
				response => {
					this.vehiculos = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this._EmpresaService.getEmpresa().subscribe(
				response => {
					this.empresas = response.data;
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
		this._VehiculoPesadoService.register(this.vehiculoPesado,token).subscribe(
			response => {
				this.respuesta = response;
				if(this.respuesta.status=="success") {
					 this.tramiteCreado.emit(true);
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

	onKeyEmpresa(event:any){
		let nit = {
			'nit' : event,
		};
		let token = this._loginService.getToken();
		this._EmpresaService.showNit(token,nit).subscribe(
			response => {
				let status = response.status;
				if(status=="error") {
					this.validateCedula=false;
					this.claseSpanCedula ="glyphicon glyphicon-remove form-control-feedback";
					this.claseCedula = "form-group has-error has-feedback ";
					this.empresa=null;
					this.divEmpresa = null;
				}else{
					this.divEmpresa = true;
					this.empresa = response.data;
					this.validateCedula=true;
					this.claseSpanCedula ="glyphicon glyphicon-ok form-control-feedback";
					this.claseCedula = "form-group has-success has-feedback ";
					this.vehiculoPesado.empresaId=this.empresa.id;
				}
			}, 
			error => {
				this.errorMessage = <any>error;

				if(this.errorMessage != null){
					alert("Error en la petición");
				}
			}
			);
	}

	
 }
