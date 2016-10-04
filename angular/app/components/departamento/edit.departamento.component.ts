// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {DepartamentoService} from '../../services/departamento/departamento.service';
import {Departamento} from '../../model/departamento/Departamento';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/departamento/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,DepartamentoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class DepartamentoEditComponent implements OnInit{ 
	public errorMessage;
	public departamento : Departamento;
	public id;
	public respuesta;

	constructor(
		private _loginService: LoginService,
		private _DepartamentoService: DepartamentoService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	

		
		this.departamento = new Departamento(null, "",null);


		let token = this._loginService.getToken();

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._DepartamentoService.showDepartamento(token,this.id).subscribe(

						response => {
							this.departamento = response.data;
							console.log(this.departamento);
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
		console.log(token);

		this._UsuarioService.editUsuario(this.usuario,token).subscribe(
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





