// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {AlmacenService} from "../../services/almacen/almacen.service";
import {ServicioService} from "../../services/servicio/servicio.service";
import {OrganismoTransitoService} from '../../services/organismoTransito/organismoTransito.service';
import {ConsumibleService} from "../../services/consumible/consumible.service";
import {ClaseService} from "../../services/clase/clase.service";
import {Almacen} from '../../model/almacen/Almacen';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/almacen/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,ServicioService,AlmacenService,OrganismoTransitoService,AlmacenService,ConsumibleService,ClaseService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewAlmacenComponent {
	public clases;
	public consumibles;
	public errorMessage;
	public almacen: Almacen;
	public id;
	public respuesta;
	public tiposIdentificacion;
	public organismosTransito;
	public tiposAlmacen;
	public servicios;

	constructor(
		private _ClaseService: ClaseService,
		private _ConsumibleService: ConsumibleService,
		private _AlmacenService: AlmacenService,
		private _OrganismoTransitoService: OrganismoTransitoService,
		private _loginService: LoginService,
		private _ServicioService: ServicioService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.almacen = new Almacen(null,null,null,null,null,null,null,null);

		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

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

			this._ConsumibleService.getConsumible().subscribe(
				response => {
					this.consumibles = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this._AlmacenService.getAlmacen().subscribe(
				response => {
					this.tiposAlmacen = response.data;
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
	}

	onSubmit(){
		let token = this._loginService.getToken();
		this._AlmacenService.register(this.almacen,token).subscribe(
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
