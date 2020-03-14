import React, { Component, Fragment } from 'react'

import Layout from '../../components/Layout'
import { Form, Col, Row, Button, Spinner, Alert } from 'react-bootstrap'



class Crear extends Component {
    state = {
        form: {
            nombre: {
                value: '',
                valid: false,
                validation: {
                    required: true
                }
            },
            email: {
                value: '',
                valid: false,
                validation: {
                    required: true,
                    isEmail: true
                }
            },
            password: {
                value: '',
                valid: true,
                validation: {
                    required: false,
                    min: 0
                }
            }
        },
        formIsValid: false,
        formSaving: false,
        formMessages: {
            errors: null,
            msg: ''
        },
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
                    // Rellenar el state a partir de los campos encontrados
                    const updatedForm = { ...this.state.form }
                    Object.keys(updatedForm).forEach((val, i) => {
                        updatedForm[val].value = response.res[val] || '' 
                        updatedForm[val].valid = true
                    })
                    // Valida el formulario
                    let formIsValid = this.checkValidityForm(updatedForm)
                    this.setState({ 
                        loading: false, 
                        user: response.res,
                        form: updatedForm,
                        formIsValid: formIsValid
                    })
                } else {
                    this.setState({ loading: false, user: null })
                }
            })
            .catch(err => {
                console.log(err.response)
                this.setState({ loading: false, user: null })
            })
    }


    checkValidityForm(newFormData) {
        let formIsValid = true
        for (let inputId in newFormData) {
            formIsValid = newFormData[inputId].valid && formIsValid
        }
        return formIsValid
    }


    changedHandler = (ev, id) => {
        const value = ev.target.value
        const newFormData = {
            ...this.state.form,
            [id]: {
                ...this.state.form[id],
                value: value,
                valid: window.checkValidations(value, this.state.form[id].validation)
            }
        }

        let formIsValid = this.checkValidityForm(newFormData)

        this.setState({ form: newFormData, formIsValid: formIsValid })
    }



    submittedHandler = e => {
        e.preventDefault()
        
        if (this.state.formIsValid) {
            let formdata = {}
            Object.keys(this.state.form).forEach((val, i) => {
                formdata[val] = this.state.form[val].value
            })

            const updatedFormMessages = { 
                ...this.state.formMessages,
                errors: null,
                msg: ''
            }
            this.setState({ formSaving: true, formMessages: updatedFormMessages })
        
            window.axios.patch(`/api/v1/users/${this.props.match.params.id}/update`, formdata)
                .then(res => {
                    const response = res.data
                    if (('error' in response && !response.error) || !response.errors) {
                        const newFormMessagess = { 
                            ...this.state.formMessages,
                            errors: null,
                            msg: response.message
                        }
                        this.setState({ formMessages: newFormMessagess, formSaving: false });
                    }
                })
                .catch(err => {
                    const res = err.response.data
                    if (res.errors) {
                        const newFormMessagess = { 
                            ...this.state.formMessages,
                            errors: res.errors,
                            msg: res.message
                        }
                        this.setState({ formMessages: newFormMessagess, formSaving: false });
                    }
                })

        }
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

                                            {
                                                this.state.formMessages.errors || this.state.formMessages.msg.length > 0
                                                    ?
                                                        <Row>
                                                            <Col>
                                                                <Alert variant={this.state.formMessages.errors ? 'danger' : 'success'}>
                                                                    <Alert.Heading>{ this.state.formMessages.msg }</Alert.Heading>
                                                                        {
                                                                            this.state.formMessages.errors
                                                                                ?
                                                                                    <ul>
                                                                                        {
                                                                                            Object.keys(this.state.formMessages.errors).map(key => (
                                                                                                <li key={key}>{this.state.formMessages.errors[key][0]}</li>
                                                                                            ))
                                                                                        }
                                                                                    </ul>
                                                                                : null
                                                                        }
                                                                </Alert>
                                                            </Col>
                                                        </Row>
                                                    : null
                                            }

                                            <Form.Group as={Row}>
                                                <Form.Label column sm='2'>Nombre</Form.Label>
                                                <Col sm='10'>
                                                    <Form.Control type='text' placeholder='Nombre completo' value={this.state.form.nombre.value} onChange={(e) => this.changedHandler(e, 'nombre')} />
                                                </Col>
                                            </Form.Group>
                                            <Form.Group as={Row}>
                                                <Form.Label column sm='2'>Correo</Form.Label>
                                                <Col sm='10'>
                                                    <Form.Control type='email' placeholder='Correo electronico' value={this.state.form.email.value} onChange={(e) => this.changedHandler(e, 'email')} />
                                                </Col>
                                            </Form.Group>
                                            <Form.Group as={Row}>
                                                <Form.Label column sm='2'>Contraseña</Form.Label>
                                                <Col sm='10'>
                                                    <Form.Control type='password' placeholder='Una contraseña segura de minimo 6 caracteres' value={this.state.form.password.value} onChange={(e) => this.changedHandler(e, 'password')} />
                                                </Col>
                                            </Form.Group>
                                            <Form.Group as={Row}>
                                                <Col sm={{ span: 10, offset: 2 }}>
                                                    <Button type='submit' block disabled={!this.state.formIsValid || this.state.formSaving}>Registrar usuario</Button>
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