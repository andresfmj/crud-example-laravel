import React, { Component } from 'react'

import Layout from '../../components/Layout'
import { Form, Col, Row, Button, Alert } from 'react-bootstrap'



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
                valid: false,
                validation: {
                    required: true,
                    min: 6
                }
            }
        },
        formIsValid: false,
        formSaving: false,
        formMessages: {
            errors: null,
            msg: ''
        }
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

        let formIsValid = true
        for (let inputId in newFormData) {
            formIsValid = newFormData[inputId].valid && formIsValid
        }

        this.setState({ form: newFormData, formIsValid: formIsValid })
    }

    submittedHandler = ev => {
        ev.preventDefault()
        
        if (this.state.formIsValid) {
            let formdata = {}
            Object.keys(this.state.form).forEach((val, i) => {
                formdata[val] = this.state.form[val].value
            })

            this.setState({ formSaving: true })
            
            window.axios.post('/api/v1/users/store', formdata)
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
                <h4>Crear nuevo usuario</h4>
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
                            <Form.Control type='text' placeholder='Nombre completo' onChange={(e) => this.changedHandler(e, 'nombre')} value={this.state.form.nombre.value} />
                        </Col>
                    </Form.Group>
                    <Form.Group as={Row}>
                        <Form.Label column sm='2'>Correo</Form.Label>
                        <Col sm='10'>
                            <Form.Control type='email' placeholder='Correo electronico' onChange={(e) => this.changedHandler(e, 'email')} value={this.state.form.email.value} />
                        </Col>
                    </Form.Group>
                
                    <Form.Group as={Row}>
                        <Form.Label column sm='2'>Contraseña</Form.Label>
                        <Col sm='10'>
                            <Form.Control type='password' placeholder='Una contraseña segura de minimo 6 caracteres' onChange={(e) => this.changedHandler(e, 'password')} value={this.state.form.password.value} />
                        </Col>
                    </Form.Group>

                    <Form.Group as={Row}>
                        <Col sm={{ span: 10, offset: 2 }}>
                            <Button type='submit' block disabled={!this.state.formIsValid || this.state.formSaving}>Registrar usuario</Button>
                        </Col>
                    </Form.Group>
                    
                </Form>
            </Layout>
        )
    }
}

export default Crear