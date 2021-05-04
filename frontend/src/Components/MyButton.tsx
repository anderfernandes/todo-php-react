import React, { MouseEventHandler } from 'react'

interface IMyButtonProps {
    Text: string,
    // This enum ensures that the user only enters one of the strings below.
    // These come from bootstrap button classes. The question mark (?) in here
    // means that this is an optional property
    Type?: 'primary' | 'secondary' | 'success' | 'danger' | 'warning',
    // If we don't do this, our custom component won't have an event handler
    onClick?: MouseEventHandler<HTMLButtonElement>
}

export default function MyButton({ Text, Type, onClick } : IMyButtonProps) {

    // If we don´t enter a button type, we will set the default value to "primary"
    if (!Type)
        Type = 'primary'

    return (
        <button className={`btn btn-${Type}`} onClick={onClick}>
            {Text}
        </button>
    )
}