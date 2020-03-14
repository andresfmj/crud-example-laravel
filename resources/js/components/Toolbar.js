import React from 'react'
import { Navbar, Nav } from 'react-bootstrap'
import { NavLink } from 'react-router-dom';

const toolbar = props => (
    <Navbar collapseOnSelect expand="lg" role='navigation' bg='dark' variant='dark'>
        <NavLink to='/react/home' className='navbar-brand'>{process.env.MIX_APP_NAME}</NavLink>
        <Navbar.Toggle />
        <Navbar.Collapse className='justify-content-end'>
            <Nav>
                <NavLink to='/react/home/users' className='nav-link'>Usuarios</NavLink>
                <NavLink to='/react/home/citas' className='nav-link'>Citas</NavLink>
            </Nav>
        </Navbar.Collapse>
    </Navbar>
)

export default toolbar