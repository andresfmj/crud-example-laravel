import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch, Redirect } from 'react-router-dom';

import Login from './containers/Login'


export default class App extends Component {

    render() {
        return (
            <Fragment>
                <Switch>
                    <Route path='/home/citas/:id/editar' render={() => <h2>Editing cita: :id</h2>} />
                    <Route path='/home/citas/nuevo' render={() => <h2>Nueva cita</h2>} />
                    <Route path='/home/citas' render={() => <h2>Listado de Citas</h2>} />

                    <Route path='/home/users/:id/editar' render={() => <h2>Editing user: :id</h2>} />
                    <Route path='/home/users/nuevo' render={() => <h2>Nuevo usuario</h2>} />
                    <Route path='/home/users' render={() => <h2>Users list</h2>} />
                    <Route path='/home' render={() => <h2>Home</h2>} />
                    
                    <Route path='/user/login' component={Login} />
                    
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
