// Importar el núcleo de Angular
import {LoginService} from "../../services/login.service";
import {Component, OnInit} from '@angular/core';
import {MarcaService} from '../../services/marca/marca.service';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {Marca} from '../../model/marca/marca';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/marca/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,MarcaService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewMarcaComponent {
	public marca: Marca;
	public errorMessage;
	public respuesta;

	constructor(
		private _MarcaService:MarcaService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.marca = new Marca(null, "", null);

	}

	onSubmit(){
		console.log(this.marca);
		let token = this._loginService.getToken();

		this._MarcaService.register(this.marca,token).subscribe(
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
