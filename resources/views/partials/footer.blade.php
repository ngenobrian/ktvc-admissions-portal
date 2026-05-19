<footer class="pt-5 pb-3 mt-auto" style="background-color: #7B1818; color: #f8f9fa; border-top: 5px solid #C89D3C;">
    <div class="container">
        <div class="row">
            
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-uppercase mb-3" style="color: #C89D3C;">Kipkabus TVC</h5>
                <p class="small mb-3" style="line-height: 1.6; color: #f8f9fa;">
                    Providing quality technical and vocational training to empower students with knowledge, skills, and innovation for national development.
                </p>
                <p class="small mb-0" style="color: #f8f9fa;">
                    &copy; {{ date('Y') }} Kipkabus Technical and Vocational College.<br>All Rights Reserved.
                </p>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-uppercase mb-3" style="color: #C89D3C;">Useful Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ url('/') }}" class="text-decoration-none footer-link" style="color: #f8f9fa;">
                            <i class="fas fa-angle-right me-2 mr-2" style="color: #C89D3C;"></i> Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('programmes') }}" class="text-decoration-none footer-link" style="color: #f8f9fa;">
                            <i class="fas fa-angle-right me-2 mr-2" style="color: #C89D3C;"></i> Our Programmes
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('enquiry.page') }}" class="text-decoration-none footer-link" style="color: #f8f9fa;">
                            <i class="fas fa-angle-right me-2 mr-2" style="color: #C89D3C;"></i> Help & Enquiries
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('login') }}" class="text-decoration-none footer-link" style="color: #f8f9fa;">
                            <i class="fas fa-angle-right me-2 mr-2" style="color: #C89D3C;"></i> Trainee Login
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('register') }}" class="text-decoration-none footer-link" style="color: #f8f9fa;">
                            <i class="fas fa-angle-right me-2 mr-2" style="color: #C89D3C;"></i> New Application
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-uppercase mb-3" style="color: #C89D3C;">Contact Us</h5>
                <ul class="list-unstyled small" style="color: #f8f9fa;">
                    <li class="mb-3 d-flex">
                        <i class="fas fa-map-marker-alt mt-1 me-3 mr-3 fs-5" style="color: #C89D3C;"></i>
                        <div>
                            <strong>Location:</strong><br>
                            P.O BOX 10882-30100<br>
                            Eldoret, Kenya
                        </div>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-phone-alt me-3 mr-3 fs-5" style="color: #C89D3C;"></i>
                        <span><strong>Tel:</strong> 0717 130 180</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-envelope me-3 mr-3 fs-5" style="color: #C89D3C;"></i>
                        <span><strong>Email:</strong> info@ktvc.ac.ke</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</footer>

<style>
    /* Hover effect: Turns the text Gold and slightly indents it when hovered */
    .footer-link {
        transition: all 0.3s ease;
    }
    .footer-link:hover {
        color: #C89D3C !important;
        text-decoration: underline !important;
        padding-left: 5px;
    }
</style>