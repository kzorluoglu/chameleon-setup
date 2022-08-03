import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';

import React from "react";
import {
    Route, Routes
} from "react-router-dom";

import Home from "./Page/Home";
import Requirements from "./Page/Requirements";
import Install from "./Page/Install";
import Database from "./Page/Database";

export default function App() {
    return (
        <>
            <Routes>
                <Route index element={<Home/>}/>
                <Route path="requirements" element={<Requirements/>}/>
                <Route path="install" element={<Install/>}/>
                <Route path="database" element={<Database/>}/>
            </Routes>
        </>
    );
}

