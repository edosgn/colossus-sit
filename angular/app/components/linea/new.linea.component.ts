// Importar el núcleo de Angular
import {LineaService} from "../../services/linea/linea.service";
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {MarcaService} from '../../services/marca/marca.service';
import {Linea} from '../../model/linea/linea';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/linea/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,LineaService,MarcaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewLineaComponent {
	public linea: Linea;
	public errorMessage;
	public respuesta;
	public marcas;

	constructor(
		private _MarcaService:MarcaService,
		private _LineaService:LineaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.linea = new Linea(null,null,"",null);

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
		console.log(this.linea);
		let token = this._loginService.getToken();
		this._LineaService.register(this.linea,token).subscribe(
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
