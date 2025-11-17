<!-- Featured Motels / Our Exquisite Rooms Section -->
@if(isset($spotlightMotels) && $spotlightMotels->isNotEmpty())
    <section class="exquisite-rooms-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header" data-aos="fade-up">
                 <h2 class="section-title">Our Exquisite Stays</h2>
                <p class="section-subtitle">
                    Choose from carefully curated motels designed to deliver elevated hospitality, 
                    signature amenities, and bespoke service tailored to your refined taste.
                 </p>
            </div>

            <!-- Motels Grid -->
            <div class="motels-grid">
                @foreach($spotlightMotels as $index => $motel)
                    <article class="motel-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <!-- Image Container with Overlay -->
                        <div class="motel-image-wrapper">
                            <img src="{{ $motel['image'] }}" 
                                 alt="{{ $motel['name'] }}" 
                                 class="motel-image"
                                 loading="lazy">
                            <div class="image-overlay">
                                <a href="{{ route('website.motels.show', $motel['id']) }}" 
                                   class="quick-view-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="10" cy="10" r="7"/>
                                        <path d="M10 6v8M6 10h8"/>
                                    </svg>
                                    Quick View
                                </a>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="motel-content">
                            <div class="motel-header">
                                <h3 class="motel-title">{{ $motel['name'] }}</h3>
                              
                            </div>
                            
                            <p class="motel-description">{{ $motel['description'] }}</p>

                         
                            <!-- Footer with Price and CTA -->
                            <div class="motel-footer">
                                 <a href="{{ route('website.motels.show', $motel['id']) }}" 
                                   class="view-details-btn">
                                    View Details
                                   
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            
        </div>
    </section>
@endif

<style>
/* ============================================
   Exquisite Rooms Section - Modern & Responsive
   ============================================ */

.exquisite-rooms-section {
    padding: 40px 0 60px;
    background: linear-gradient(180deg, #fafafa 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
}

.exquisite-rooms-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #e5e5e5 50%, transparent);
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Section Header */
.section-header {
    text-align: center;
    max-width: 720px;
    margin: 0 auto 40px;
}

.section-badge {
    display: inline-block;
    padding: 8px 20px;
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    border-radius: 50px;
    margin-bottom: 24px;
}

.section-title {
    font-size: clamp(32px, 5vw, 48px);
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 16px;
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.section-subtitle {
    font-size: 18px;
    line-height: 1.7;
    color: #666;
    margin: 0;
}

/* Motels Grid */
.motels-grid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 24px;
    margin-bottom: 64px;
}

/* Motel Card */
.motel-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
}

.motel-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.12);
}

/* Image Wrapper */
.motel-image-wrapper {
    position: relative;
    height: 280px;
    overflow: hidden;
    background: #f5f5f5;
}

.motel-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.motel-card:hover .motel-image {
    transform: scale(1.08);
}

.image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.motel-card:hover .image-overlay {
    opacity: 1;
}

.quick-view-btn {
    padding: 12px 24px;
    background: #ffffff;
    color: #1a1a1a;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    transform: translateY(10px);
}

.motel-card:hover .quick-view-btn {
    transform: translateY(0);
}

.quick-view-btn:hover {
    background: #1a1a1a;
    color: #ffffff;
}

/* Card Content */
.motel-content {
    padding: 28px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    flex: 1;
}

.motel-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
}

.motel-title {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    line-height: 1.3;
    flex: 1;
}

.motel-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 6px 12px;
    background: #fff9e6;
    border-radius: 50px;
    color: #d4a017;
    font-size: 14px;
    font-weight: 600;
}

.motel-rating svg {
    fill: #d4a017;
}

.motel-description {
    font-size: 15px;
    line-height: 1.6;
    color: #666;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Amenities */
.motel-amenities {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.amenity-tag {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: #f5f5f5;
    border-radius: 50px;
    font-size: 13px;
    color: #444;
    font-weight: 500;
    transition: all 0.3s ease;
}

.amenity-tag:hover {
    background: #1a1a1a;
    color: #ffffff;
}

.amenity-tag svg {
    flex-shrink: 0;
}

/* Footer */
.motel-footer {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 16px;
    padding-top: 20px;
    border-top: 1px solid #eee;
    margin-top: auto;
}

.price-container {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.price-label {
    font-size: 12px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

.price {
    display: flex;
    align-items: baseline;
    gap: 4px;
}

.currency {
    font-size: 18px;
    color: #1a1a1a;
    font-weight: 600;
}

.amount {
    font-size: 32px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1;
}

.period {
    font-size: 14px;
    color: #999;
    font-weight: 500;
}

.contact-price {
    font-size: 14px;
    color: #666;
    font-weight: 500;
    font-style: italic;
}

.view-details-btn {
    padding: 14px 28px;
    background: #1a1a1a;
    color: #ffffff;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    white-space: nowrap;
}

.view-details-btn:hover {
    background: #333;
    transform: translateX(4px);
}

.view-details-btn svg {
    transition: transform 0.3s ease;
}

.view-details-btn:hover svg {
    transform: translateX(4px);
}

/* Section Footer */
.section-footer {
    text-align: center;
}

.view-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 16px 40px;
    background: transparent;
    color: #1a1a1a;
    border: 2px solid #1a1a1a;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.view-all-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: #1a1a1a;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
    z-index: -1;
}

.view-all-btn:hover::before {
    transform: scaleX(1);
}

.view-all-btn:hover {
    color: #ffffff;
}

.view-all-btn svg {
    transition: transform 0.3s ease;
}

.view-all-btn:hover svg {
    transform: translateX(6px);
}

.view-all-text-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 24px;
    margin-left: 12px;
    border-radius: 999px;
    border: 1px solid rgba(26, 26, 26, 0.2);
    font-size: 14px;
    font-weight: 600;
    color: #1a1a1a;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: rgba(26, 26, 26, 0.04);
    cursor: default;
}

/* ============================================
   Responsive Design
   ============================================ */

@media (max-width: 1024px) {
    .exquisite-rooms-section {
        padding: 80px 0;
    }
    
}

@media (max-width: 768px) {
    .exquisite-rooms-section {
        padding: 60px 0;
    }
    
    .section-header {
        margin-bottom: 48px;
    }
    
    .motels-grid {
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 48px;
    }
    
    .motel-image-wrapper {
        height: 240px;
    }
    
    .motel-content {
        padding: 20px;
    }
    
    .motel-title {
        font-size: 20px;
    }
    
    .motel-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
    }
    
    .view-details-btn {
        width: 100%;
        justify-content: center;
    }
    
    .view-all-btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 1600px) {
    .motels-grid {
        grid-template-columns: repeat(5, minmax(0, 1fr));
    }
}

@media (max-width: 1400px) {
    .motels-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

@media (max-width: 1100px) {
    .motels-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 900px) {
    .motels-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 480px) {
    .container {
        padding: 0 16px;
    }
    
    .section-badge {
        font-size: 11px;
        padding: 6px 16px;
    }
    
    .section-subtitle {
        font-size: 16px;
    }
    
    .motel-content {
        padding: 16px;
        gap: 16px;
    }
    
    .amount {
        font-size: 28px;
    }
    
    .quick-view-btn {
        font-size: 13px;
        padding: 10px 20px;
    }
}

/* Dark Mode Support (Optional) */
@media (prefers-color-scheme: dark) {
    .exquisite-rooms-section {
        background: linear-gradient(180deg, #0a0a0a 0%, #1a1a1a 100%);
    }
    
    .section-title {
        color: #ffffff;
    }
    
    .section-subtitle {
        color: #aaa;
    }
    
    .motel-card {
        background: #2d2d2d;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.3);
    }
    
    .motel-title {
        color: #ffffff;
    }
    
    .motel-description {
        color: #aaa;
    }
    
    .amenity-tag {
        background: #3a3a3a;
        color: #ddd;
    }
    
    .view-details-btn {
        background: #ffffff;
        color: #1a1a1a;
    }
    
    .view-all-btn {
        border-color: #ffffff;
        color: #ffffff;
    }
    
    .view-all-btn::before {
        background: #ffffff;
    }
    
    .view-all-btn:hover {
        color: #1a1a1a;
    }
}
</style>