import React, { Component } from 'react'
import { Table, Spinner, Button } from 'react-bootstrap'

import Layout from '../../components/Layout'
import { Link } from 'react-router-dom'

import Editar from './Editar'


class Usuarios extends Component {
    state = {
        users: null,
        loading: false
    }

    componentDidMount() {
        console.log('(Usuarios) DidMount')

        this.setState({ loading: true })

        window.axios.get('/api/v1/users')
            .then(res => {
                const response = res.data
                if (!response.error) {
                    this.setState({ loading: false, users: response.res.data })
                } else {
                    this.setState({ loading: false, users: null })
                }
            })
            .catch(err => {
                console.log(err.response)
                this.setState({ loading: false, users: null })
            })
    }


    removedHandler = id => {
        console.log('remove user: ', id)
    }

    clickedNewUser = () => {
        this.props.history.replace(this.props.match.url + '/nuevo')
    }


    render() {
        return (
            <Layout>
                <div className='Action--Toolbar'>
                    <h4>Usuarios</h4>
                    <div className="buttons-actions">
                        <Button variant='primary' size='sm' onClick={this.clickedNewUser}>Nuevo</Button>
                    </div>
                </div>
                <Table bordered responsive size='sm' striped>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Registrado desde</th>
                            <th>Modificado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            this.state.loading 
                                ? 
                                    <tr>
                                        <td colSpan='6' className='text-center'><Spinner animation='border' size='sm' role='status' /></td>
                                    </tr>
                                : 
                                    this.state.users && this.state.users.map(i => (
                                        <tr key={i.id}>
                                            <td>{i.id}</td>
                                            <td>{i.nombre}</td>
                                            <td>{i.email}</td>
                                            <td>{window.moment(i.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow()}</td>
                                            <td>{window.moment(i.updated_at, 'YYYY-MM-DD HH:mm:ss').fromNow()}</td>
                                            <td className='text-center'><Link to={`/react/home/users/${i.id}/editar`}>Editar</Link> | <a href='#eliminar' onClick={() => this.removedHandler(i.id)}>Eliminar</a></td>
                                        </tr>
                                    ))
                        }
                    </tbody>
                </Table>
            </Layout>
        )
    }
}

export default Usuarios