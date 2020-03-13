import React from 'react'


const layout = props => (
    <div className='Layout'>
        <div className='Toolbar'>Toolbar</div>
        {props.children}
    </div>
)

export default layout