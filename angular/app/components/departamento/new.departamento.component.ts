// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {DepartamentoService} from '../../services/departamento/departamento.service';
import {Departamento} from '../../model/departamento/Departamento';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/departamento/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,DepartamentoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewDepartamentoComponent {
	public departamento: Departamento;
	public errorMessage;
	public respuesta;

	constructor(
		private _DepartementoService:DepartamentoService,
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.departamento = new Departamento(null, "", null);

	}

	onSubmit(){
		console.log(this.departamento);
		let token = this._loginService.getToken();

		this._DepartementoService.register(this.departamento,token).subscribe(
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
