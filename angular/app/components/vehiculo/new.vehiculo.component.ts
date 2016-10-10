// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {MunicipioService} from '../../services/municipio/municipio.service';
import {LineaService} from '../../services/linea/linea.service';
import {ServicioService} from '../../services/servicio/servicio.service';
import {ColorService} from '../../services/color/color.service';
import {ClaseService} from '../../services/clase/clase.service';
import {CombustibleService} from '../../services/combustible/combustible.service';
import {CarroceriaService} from '../../services/carroceria/carroceria.service';
import {OrganismoTransitoService} from '../../services/organismoTransito/organismoTransito.service';
import {VehiculoService} from "../../services/vehiculo/vehiculo.service";
import {Vehiculo} from '../../model/vehiculo/Vehiculo';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/vehiculo/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,VehiculoService,MunicipioService,LineaService,ServicioService,ColorService,CombustibleService,CarroceriaService,OrganismoTransitoService,ClaseService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewVehiculoComponent {
	public vehiculo: Vehiculo;
	public errorMessage;
	public respuesta;
	public municipios;
	public lineas;
	public servicios;
	public colores;
	public combustibles;
	public carrocerias;
	public clases;
	public organismosTransito;

	constructor(
		private _MunicipioService: MunicipioService,
		private _LineaService: LineaService,
		private _ServicioService: ServicioService,
		private _ColorService: ColorService,
		private _ClaseService: ClaseService,
		private _CombustibleService: CombustibleService,
		private _CarroceriaService: CarroceriaService,
		private _OrganismoTransitoService: OrganismoTransitoService,	
		private _VehiculoService:VehiculoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.vehiculo = new Vehiculo(null,null,null,null,null,null,null,null,null,"","","","","","","","","","","",null,null);
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
		this._LineaService.getLinea().subscribe(
				response => {
					this.lineas = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this._ServicioService.getServicio().subscribe(
				response => {
					this.servicios = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
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
		this._CombustibleService.getCombustible().subscribe(
				response => {
					this.combustibles = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this._CarroceriaService.getCarroceria().subscribe(
				response => {
					this.carrocerias = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this._OrganismoTransitoService.getOrganismoTransito().subscribe(
				response => {
					this.organismosTransito = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this._ClaseService.getClase().subscribe(
				response => {
					this.clases = response.data;
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
		this._VehiculoService.register(this.vehiculo,token).subscribe(
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
