@extends('ui::layouts.master')

@section('title', 'SaluteOra - Salute Orale per Gestanti')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">Salute Orale per le Gestanti</h1>
                    <p class="lead mb-4">Promuoviamo la salute orale per le gestanti in condizioni di vulnerabilità socio-economica attraverso un percorso di cura gratuito e di qualità.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="/verificare-idoneita" class="btn btn-primary">Verificare Idoneità</a>
                        <a href="/chi-siamo" class="btn btn-outline-primary">Scopri di Più</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1516585427167-9f4af9627e6c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2000&q=80" alt="Donna incinta che sorride" class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Info Cards Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold">Il Nostro Programma</h2>
                    <p class="lead">Un'iniziativa dedicata a supportare la salute orale delle gestanti con ISEE inferiore a 20.000€</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-check-circle fa-3x text-primary"></i>
                            </div>
                            <h4 class="card-title">Verifica Idoneità</h4>
                            <p class="card-text">Verifica online se possiedi i requisiti per accedere al programma gratuito di cure odontoiatriche.</p>
                            <a href="/verificare-idoneita" class="btn btn-sm btn-outline-primary mt-3">Verifica Ora</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-calendar-check fa-3x text-primary"></i>
                            </div>
                            <h4 class="card-title">Prenotazione</h4>
                            <p class="card-text">Prenota facilmente la tua visita presso uno dei nostri centri odontoiatrici convenzionati.</p>
                            <a href="/prenotare-visita" class="btn btn-sm btn-outline-primary mt-3">Prenota Visita</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-tooth fa-3x text-primary"></i>
                            </div>
                            <h4 class="card-title">Trattamenti</h4>
                            <p class="card-text">Accedi a un programma completo di cure odontoiatriche specifiche per il periodo della gravidanza.</p>
                            <a href="/servizi" class="btn btn-sm btn-outline-primary mt-3">Scopri i Trattamenti</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1588776814546-daab30f310ce?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2000&q=80" alt="Dentista con paziente" class="img-fluid rounded-3 shadow">
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h2 class="fw-bold mb-4">Perché è Importante</h2>
                    <p class="mb-4">La salute orale durante la gravidanza è fondamentale non solo per il benessere della madre, ma anche per quello del nascituro. Problemi dentali non trattati possono avere conseguenze significative sulla salute generale.</p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Prevenzione di complicazioni della gravidanza</li>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Riduzione del rischio di parto pretermine</li>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Promozione della salute orale del bambino</li>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Miglioramento della qualità della vita</li>
                    </ul>
                    <a href="/chi-siamo" class="btn btn-primary mt-3">Leggi di Più</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold">Testimonianze</h2>
                    <p class="lead">Ascolta le storie delle gestanti che hanno beneficiato del nostro programma</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Testimonianza" class="rounded-circle" width="60" height="60">
                                <div class="ms-3">
                                    <h5 class="mb-0">Martina R.</h5>
                                    <small class="text-muted">Milano</small>
                                </div>
                            </div>
                            <p class="fst-italic mb-0">"Grazie a SaluteOra ho potuto risolvere problemi dentali che rimandavo da tempo per motivi economici. Il personale è stato estremamente gentile e professionale."</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://randomuser.me/api/portraits/women/67.jpg" alt="Testimonianza" class="rounded-circle" width="60" height="60">
                                <div class="ms-3">
                                    <h5 class="mb-0">Giulia F.</h5>
                                    <small class="text-muted">Roma</small>
                                </div>
                            </div>
                            <p class="fst-italic mb-0">"Non avrei mai immaginato quanto fosse importante la salute orale durante la gravidanza. SaluteOra mi ha aiutato a prendermi cura di me e del mio bambino."</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://randomuser.me/api/portraits/women/33.jpg" alt="Testimonianza" class="rounded-circle" width="60" height="60">
                                <div class="ms-3">
                                    <h5 class="mb-0">Alessandra M.</h5>
                                    <small class="text-muted">Napoli</small>
                                </div>
                            </div>
                            <p class="fst-italic mb-0">"Il processo di verifica dell'idoneità è stato semplice e veloce. In pochi giorni ho potuto accedere alle cure di cui avevo bisogno senza preoccupazioni economiche."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section class="section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold">Domande Frequenti</h2>
                    <p class="lead">Trova le risposte alle domande più comuni sul nostro programma</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Chi può accedere al programma SaluteOra?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Il programma è destinato alle donne in gravidanza con un ISEE inferiore a 20.000€. È necessario fornire documentazione che attesti sia lo stato di gravidanza che la situazione economica.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Quali trattamenti sono inclusi nel programma?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Il programma include visite di controllo, detartrasi (pulizia dei denti), trattamenti conservativi (otturazioni), ed eventuali cure urgenti necessarie durante la gravidanza. Tutti i trattamenti sono adattati alle esigenze specifiche delle donne in gravidanza.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Come posso prenotare una visita?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Dopo aver verificato la tua idoneità, potrai prenotare una visita direttamente dal nostro sito web o chiamando il numero dedicato. Ti verrà assegnato un dentista convenzionato vicino alla tua zona di residenza.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Il programma è disponibile in tutta Italia?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Attualmente il programma è attivo in diverse regioni italiane e viene costantemente esteso. Puoi verificare la disponibilità nella tua zona durante il processo di verifica dell'idoneità.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="/faq" class="btn btn-outline-primary">Vedi Tutte le FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section bg-primary text-white">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-4">Pronta a prenderti cura della tua salute orale?</h2>
                    <p class="lead mb-4">Verifica subito la tua idoneità e accedi al programma gratuito di cure odontoiatriche per gestanti.</p>
                    <a href="/verificare-idoneita" class="btn btn-light btn-lg px-5">Verifica Ora</a>
                </div>
            </div>
        </div>
    </section>
@endsection
