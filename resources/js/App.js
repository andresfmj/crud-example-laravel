import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch, Redirect } from 'react-router-dom';

import Login from './containers/Login'

import Home from './pages/Home'

import Usuarios from './pages/Usuarios/Index'
import CrearUsuario from './pages/Usuarios/Crear'
import EditarUsuario from './pages/Usuarios/Editar'

import Citas from './pages/Citas'


export default class App extends Component {

    render() {
        return (
            <Fragment>
                <Switch>
                    <Route path='/react/home/citas/:id/editar' render={() => <h2>Editing cita: :id</h2>} />
                    <Route path='/react/home/citas/nuevo' render={() => <h2>Nueva cita</h2>} />
                    <Route path='/react/home/citas' component={Citas} />

                    <Route path='/react/home/users/:id/editar' component={EditarUsuario} />
                    <Route path='/react/home/users/nuevo' component={CrearUsuario} />
                    <Route path='/react/home/users' component={Usuarios} />
                    <Route path='/react/home' component={Home} />
                    
                    <Route path='/react/user/login' component={Login} />
                    
                    {/* <Route exact path='/' render={() => <h3>Index</h3>} /> */}
                    <Route render={() => <h1>404 Not Found</h1>} />
                </Switch>
            </Fragment>
        );
    }
}

const app = (
    <Router basename='/'>
        <App />
    </Router>
)

if (document.getElementById('app')) {
    ReactDOM.render(app, document.getElementById('app'));
}
