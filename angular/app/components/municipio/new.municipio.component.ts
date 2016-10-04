// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {MunicipioService} from '../../services/municipio/municipio.service';
import {Municipio} from '../../model/municipio/Municipio';
import {DepartamentoService} from '../../services/departamento/departamento.service';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/municipio/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,MunicipioService,DepartamentoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewMunicipioComponent {
	public municipio: Municipio;
	public errorMessage;
	public respuesta;
	public departamentos;

	constructor(
		private _DepartamentoService:DepartamentoService,
		private _MunicipioService:MunicipioService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		

		this.municipio = new Municipio(null,null, "", null);
		let token = this._loginService.getToken();
		this._DepartamentoService.getDepartamento().subscribe(
				response => {
					this.departamentos = response.data;
					console.log(this.departamentos[0].nombre);
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

		this._MunicipioService.register(this.municipio,token).subscribe(
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
