import React, { Component, Fragment } from 'react'

import Layout from '../../components/Layout'
import { Form, Col, Row, Button, Spinner } from 'react-bootstrap'



class Crear extends Component {
    state = {
        user: null,
        loading: false
    }

    componentDidMount() {
        console.log('(Usuarios_Crear) DidMount', this.props.match.params.id)

        this.setState({ loading: true })

        window.axios.get(`/api/v1/users/${this.props.match.params.id}`)
            .then(res => {
                const response = res.data
                if ( !response.error ) {
                    this.setState({ loading: false, user: response.res })
                } else {
                    this.setState({ loading: false, user: null })
                }
            })
            .catch(err => {
                console.log(err.response)
                this.setState({ loading: false, user: null })
            })
    }

    submittedHandler = e => {
        e.preventDefault()
        alert('updating user')
    }


    render() {
        return (
            <Layout>
                {
                    this.state.loading 
                        ? <Spinner animation='border' size='sm' role='status' />
                        :
                            this.state.user 
                                ?
                                    <Fragment>
                                        <h4>Editando el usuario: {this.state.user.nombre}</h4>
                                        <Form className='container' onSubmit={this.submittedHandler}>
                                            <Form.Group as={Row}>
                                                <Form.Label column sm='2'>Nombre</Form.Label>
                                                <Col sm='10'>
                                                    <Form.Control type='text' placeholder='Nombre completo' value={this.state.user.nombre} />
                                                </Col>
                                            </Form.Group>
                                            <Form.Group as={Row}>
                                                <Form.Label column sm='2'>Correo</Form.Label>
                                                <Col sm='10'>
                                                    <Form.Control type='email' placeholder='Correo electronico' value={this.state.user.email} />
                                                </Col>
                                            </Form.Group>
                                            <Form.Group as={Row}>
                                                <Form.Label column sm='2'>Contraseña</Form.Label>
                                                <Col sm='10'>
                                                    <Form.Control type='password' placeholder='Una contraseña segura de minimo 6 caracteres' />
                                                </Col>
                                            </Form.Group>
                                            <Form.Group as={Row}>
                                                <Col sm={{ span: 10, offset: 2 }}>
                                                    <Button type='submit' block>Registrar usuario</Button>
                                                </Col>
                                            </Form.Group>
                                        </Form>
                                    </Fragment>
                                : <h4 className='text-center'>Usuario no encontrado</h4>
                }
            </Layout>
        )
    }
}

export default Crear