import Image from 'react-bootstrap/Image';
import Button from 'react-bootstrap/Button';
import { useNavigate } from 'react-router-dom';
import Col from 'react-bootstrap/Col';
import Row from 'react-bootstrap/Row';
import {BsFillArrowRightSquareFill} from "react-icons/bs";


export default function Home() {

    const navigate = useNavigate();

    return (
        <Row>
            <Col>
                <div className="p-5">
                    <div className="mb-5">
                        <span className="badge bg-secondary">Step 1</span>
                        <h3 className="h4 font-weight-bold text-theme">Welcome to Chameleon setup wizard</h3>
                    </div>
                    <h6 className="h5 mb-0">Chameleon System: e-Commerce and Content Management in one</h6>
                    <br />
                        <p className="text-muted mt-2 mb-5">with Chameleon you no longer have to decide whether you want
                            to use an online shop with a CMS function or a CMS with a shop module - you get both
                            together in one package - without any compromises.</p>

                        <Button variant="primary" onClick={() => navigate('/requirements')}><BsFillArrowRightSquareFill/> Check System requirements</Button>

                </div>
            </Col>
            <Col>
                <Image src="https://www.esono.de/chameleon/mediapool/7/fa/packshot_id4191.png" />
            </Col>
        </Row>);
}