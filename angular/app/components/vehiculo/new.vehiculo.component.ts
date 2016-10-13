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
    selector: 'register',
    template: 'as{{saludo}}',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,VehiculoService,MunicipioService,LineaService,ServicioService,ColorService,CombustibleService,CarroceriaService,OrganismoTransitoService,ClaseService,DepartamentoService,MarcaService]
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
	public departamentos;
	public departamento;
	public habilitar;
	public habilitarl;
	public habilitarc;
	public marcas;
	public marca;

	constructor(
		private _MunicipioService: MunicipioService,
		private _LineaService: LineaService,
		private _ServicioService: ServicioService,
		private _ColorService: ColorService,
		private _ClaseService: ClaseService,
		private _DepartamentoService: DepartamentoService,
		private _MarcaService: MarcaService,
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
					this.vehiculo.municipioId=this.municipios[0].id;
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
	onChangeM(marcaValue) {

	this.marca ={
			"marcaId":marcaValue,
	};
    let token = this._loginService.getToken();
    this._LineaService.getLineasMar(this.marca,token).subscribe(
				response => {
					this.lineas = response.data;
					this.vehiculo.lineaId=this.lineas[0].id;
					this.habilitarl=false;
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
	onChangeC(claseValue) {
    let token = this._loginService.getToken();
    this._CarroceriaService.getCarroceriasClase(claseValue,token).subscribe(
				response => {
					this.carrocerias = response.data;
					this.vehiculo.carroceriaId=this.carrocerias[0].id;
					this.habilitarc=false;
					console.log(this.carrocerias);
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
		this.habilitar=true;
		this.habilitarl=true;
		this.habilitarc=true;
		this.vehiculo = new Vehiculo(null,null,null,null,null,null,null,null,null,"","","","","","","","","","","",null,null);
		let token = this._loginService.getToken();
		
		
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
