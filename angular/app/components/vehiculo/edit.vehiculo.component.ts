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
import {DepartamentoService} from "../../services/departamento/departamento.service";
import {MarcaService} from "../../services/marca/marca.service";
import {Vehiculo} from '../../model/vehiculo/Vehiculo';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/vehiculo/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,VehiculoService,MunicipioService,LineaService,ServicioService,ColorService,CombustibleService,CarroceriaService,OrganismoTransitoService,ClaseService,DepartamentoService,MarcaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class VehiculoEditComponent implements OnInit{ 
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
	public id;
	public departamentos;
	public departamento;
	public marcas;
	public data;
	public marca;

	constructor(
		private _MunicipioService: MunicipioService,
		private _DepartamentoService: DepartamentoService,
		private _MarcaService: MarcaService,
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

	onChange(departamentoValue) {
		this.departamento ={
			"departamentoId":departamentoValue,
	};
    let token = this._loginService.getToken();
    this._MunicipioService.getMunicipiosDep(this.departamento,token).subscribe(
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

	}
	onChangeM(marcaValue) {

	this.marca ={
			"marcaId":marcaValue,
	};
    let token = this._loginService.getToken();
    this._LineaService.getLineasMar(this.marca,token).subscribe(
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
	}


	ngOnInit(){	
		
		this.vehiculo = new Vehiculo(null,null,null,null,null,null,null,null,null,"","","","","","","","","","","",null,null,null,null);

		let token = this._loginService.getToken();
		

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._VehiculoService.showVehiculo(token,this.id).subscribe(

						response => {
							this.data = response.data;
							console.log(this.data);
							this.vehiculo = new Vehiculo(
								this.data.id,
								this.data.clase.id, 
								this.data.municipio.id, 
								this.data.linea.id,
								this.data.servicio.id,
								this.data.color.id,
								this.data.combustible.id,
								this.data.carroceria.id,
								this.data.organismoTransito.id,
								this.data.placa,
								this.data.numeroFactura,
								this.data.fechaFactura,
								this.data.valor,
								this.data.numeroManifiesto,
								this.data.fechaManifiesto,
								this.data.cilindraje,
								this.data.modelo,
								this.data.motor,
								this.data.chasis,
								this.data.serie,
								this.data.vin,
								this.data.numeroPasajeros
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
		this._MarcaService.getMarca().subscribe(
				response => {
					this.marcas = response.data;
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
		this._VehiculoService.editVehiculo(this.vehiculo,token).subscribe(
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





