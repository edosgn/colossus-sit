// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
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
    selector: 'register',
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
		this.vehiculoPesado = new VehiculoPesado(null,null,null,null,null,null,null,"","");
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
