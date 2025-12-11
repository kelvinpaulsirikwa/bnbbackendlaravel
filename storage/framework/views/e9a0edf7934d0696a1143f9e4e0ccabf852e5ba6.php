<?php
    $galleryItems = collect($featuredGallery ?? [])->take(5);
?>

<?php $__env->startPush('styles'); ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

        /* Enhanced Gallery - Premium Masonry Layout */
        .hpg-gallery-section {
            position: relative;
            background: #ffffff;
            margin: 0 auto;
            width: 100%;
            padding: 3rem 1rem 4rem;
            overflow: hidden;
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .hpg-gallery-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .hpg-gallery-label {
            display: inline-block;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #0ea5e9;
            margin-bottom: 1.25rem;
        }

        .hpg-gallery-heading {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin: 0 0 1.25rem;
        }

        .hpg-gallery-desc {
            font-size: 1.25rem;
            color: #475569;
            line-height: 1.7;
            max-width: 600px;
            margin: 0 auto;
        }

        .hpg-gallery-wrapper {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            grid-template-rows: repeat(2, minmax(200px, 1fr));
            grid-template-areas:
                "primary secondary tertiary"
                "primary quaternary quinary";
            grid-auto-rows: minmax(200px, 1fr);
            gap: 2px;
            padding: 0;
        }

        .hpg-gallery-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
            min-height: 100%;
        }

        .hpg-gallery-card:nth-child(1) { grid-area: primary; }
        .hpg-gallery-card:nth-child(2) { grid-area: secondary; }
        .hpg-gallery-card:nth-child(3) { grid-area: tertiary; }
        .hpg-gallery-card:nth-child(4) { grid-area: quaternary; }
        .hpg-gallery-card:nth-child(5) { grid-area: quinary; }

        .hpg-gallery-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(168, 85, 247, 0.1));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
        }

        .hpg-gallery-card:hover::before {
            opacity: 1;
        }

        .hpg-gallery-card--featured {
            grid-row: span 2;
            grid-column: span 1;
        }

        .hpg-gallery-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.16);
        }

        .hpg-gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hpg-gallery-card:hover .hpg-gallery-image {
            transform: scale(1.08);
        }

        .hpg-gallery-content {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg, 
                rgba(15, 23, 42, 0) 0%, 
                rgba(15, 23, 42, 0.4) 50%,
                rgba(15, 23, 42, 0.95) 100%
            );
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.75rem;
            color: #ffffff;
            opacity: 0;
            transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2;
        }

        .hpg-gallery-card:hover .hpg-gallery-content {
            opacity: 1;
        }

        .hpg-gallery-title {
            font-size: 1.375rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            transform: translateY(10px);
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hpg-gallery-card:hover .hpg-gallery-title {
            transform: translateY(0);
        }

        .hpg-gallery-inline-link {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 600;
            position: relative;
            transition: color 0.3s ease;
        }

        .hpg-gallery-inline-link:hover {
            color: #0284c7;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hpg-gallery-wrapper {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                grid-auto-rows: 240px;
                grid-template-rows: none;
                grid-template-areas: none;
                gap: 1rem;
            }

            .hpg-gallery-card:nth-child(-n+5) {
                grid-area: auto;
            }

            .hpg-gallery-card--featured {
                grid-row: span 2;
            }

            .hpg-gallery-title {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 768px) {
            .hpg-gallery-section {
                padding: 3rem 0.5rem;
            }

            .hpg-gallery-wrapper {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                grid-auto-rows: 220px;
                gap: 0.875rem;
            }

            .hpg-gallery-card--featured {
                grid-row: span 1;
                grid-column: span 2;
            }

            .hpg-gallery-content {
                padding: 1.25rem;
            }

            .hpg-gallery-title {
                font-size: 1.125rem;
            }
        }

        @media (max-width: 480px) {
            .hpg-gallery-heading {
                font-size: 2rem;
            }

            .hpg-gallery-desc {
                font-size: 1.1rem;
            }

            .hpg-gallery-wrapper {
                grid-template-columns: 1fr;
                grid-auto-rows: 280px;
                gap: 1rem;
            }

            .hpg-gallery-card--featured {
                grid-row: span 1;
                grid-column: span 1;
            }

            .hpg-gallery-card {
                border-radius: 16px;
            }

            .hpg-gallery-content {
                padding: 1rem;
            }

            .hpg-gallery-title {
                font-size: 1rem;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<!-- Premium Gallery Section -->
<?php if($galleryItems->isNotEmpty()): ?>
    <section class="hpg-gallery-section">
        <div class="hpg-gallery-header">
            <span class="hpg-gallery-label">Photo Gallery</span>
            <h2 class="hpg-gallery-heading"><?php echo e(__('website.home_gallery.title')); ?></h2>
            <p class="hpg-gallery-desc">
                <?php echo __('website.home_gallery.subtitle_html', [
                    'link' => '<a class="hpg-gallery-inline-link" href="'.route('website.gallery').'">'.__('website.home_gallery.link_text').'</a>'
                ]); ?>

            </p>
        </div>
        
        <div class="hpg-gallery-wrapper">
            <?php $__currentLoopData = $galleryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $cardClass = 'hpg-gallery-card';
                    if ($index === 0) {
                        $cardClass .= ' hpg-gallery-card--featured';
                    }
                    $hasMotel = !empty($featured['motel_id']);
                ?>
                <?php if($hasMotel): ?>
                    <a class="<?php echo e($cardClass); ?>"
                       href="<?php echo e(route('website.motels.show', $featured['motel_id'])); ?>"
                       aria-label="<?php echo e(__('website.home_gallery.card_aria', ['name' => $featured['motel_name']])); ?>">
                <?php else: ?>
                    <div class="<?php echo e($cardClass); ?>">
                <?php endif; ?>
                    <img 
                        class="hpg-gallery-image" 
                        src="<?php echo e($featured['url']); ?>" 
                        alt="<?php echo e($featured['motel_name']); ?>"
                        loading="lazy"
                    >
                    <div class="hpg-gallery-content">
                        <h3 class="hpg-gallery-title"><?php echo e($featured['motel_name']); ?></h3>
                    </div>
                <?php if($hasMotel): ?>
                    </a>
                <?php else: ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/websitepages/homepage/gallery.blade.php ENDPATH**/ ?>