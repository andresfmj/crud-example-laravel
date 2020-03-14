import React from 'react'
import { Container } from 'react-bootstrap'

import Toolbar from './Toolbar'


const layout = props => (
    <div className='Layout'>
        <Toolbar />        
        <Container fluid>
            {props.children}
        </Container>
    </div>
)

export default layout