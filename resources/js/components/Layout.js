import React from 'react'
import { Container, Navbar, Nav } from 'react-bootstrap'

import { NavLink } from 'react-router-dom';



const layout = props => (
    <div className='Layout'>
        <Navbar collapseOnSelect expand="lg" role='navigation' bg='dark' variant='dark'>
            <NavLink to='/react/home' className='navbar-brand'>HD Challenge</NavLink>
            <Navbar.Toggle />
            <Navbar.Collapse className='justify-content-end'>
                <Nav>
                    <NavLink to='/react/home/users' className='nav-link'>Usuarios</NavLink>
                    <NavLink to='/react/home/citas' className='nav-link'>Citas</NavLink>
                </Nav>
            </Navbar.Collapse>
        </Navbar>
        <Container fluid>
            {props.children}
        </Container>
    </div>
)

export default layout