<footer class="site-footer">
    <style>
        .site-footer {
            background: #0f172a;
            color: rgba(255, 255, 255, 0.85);
            padding: 3.5rem 0 1.5rem;
            width: 100%;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .site-footer__container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .site-footer__main {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1fr;
            gap: 3rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .site-footer__brand {
            padding-right: 2rem;
        }

        .site-footer__logo {
            font-size: 1.4rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }

        .site-footer__description {
            font-size: 0.94rem;
            line-height: 1.65;
            color: rgba(255, 255, 255, 0.65);
            margin-bottom: 1.5rem;
        }

        .site-footer__locations {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1.25rem;
        }

        .site-footer__location-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.75rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .site-footer__location-icon {
            width: 12px;
            height: 12px;
            opacity: 0.7;
        }

        .site-footer__col h3 {
            font-size: 0.9rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 1.25rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .site-footer__links {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .site-footer__links a {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.92rem;
            text-decoration: none;
            transition: color 0.2s ease;
            display: inline-block;
        }

        .site-footer__links a:hover {
            color: #ffffff;
        }

        .site-footer__links span {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.92rem;
        }

        .site-footer__subheading {
            margin-top: 1.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.6);
        }

        .site-footer__pill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }

        .site-footer__pill {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 6px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .site-footer__social {
            display: flex;
            gap: 0.65rem;
            margin-top: 1.5rem;
        }

        .site-footer__social a {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .site-footer__social a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .site-footer__bottom {
            padding-top: 1.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.87rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .site-footer__language-switch {
            display: flex;
            gap: 1rem;
        }

        .site-footer__language-switch a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: color 0.2s ease;
            font-size: 0.87rem;
        }

        .site-footer__language-switch a:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        .site-footer__language-switch a.is-active {
            color: #ffffff;
            font-weight: 500;
        }

        @media (max-width: 1024px) {
            .site-footer__main {
                grid-template-columns: 1.5fr 1fr 1fr;
                gap: 2.5rem;
            }
            
            .site-footer__col:last-child {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .site-footer__container {
                padding: 0 1.5rem;
            }

            .site-footer__main {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .site-footer__brand {
                padding-right: 0;
            }

            .site-footer__bottom {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>

    <?php ($currentLocale = app()->getLocale()); ?>
    <div class="site-footer__container">
        <div class="site-footer__main">
            <div class="site-footer__brand">
                <h2 class="site-footer__logo">bnbStay</h2>
                <p class="site-footer__description">
                    <?php echo e(__('website.footer.description')); ?>

                </p>
                <?php if(($footerCountries ?? collect())->isNotEmpty()): ?>
                    <div class="site-footer__locations">
                        <?php $__currentLoopData = ($footerCountries ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="site-footer__location-tag">
                                <svg class="site-footer__location-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <?php echo e($country); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

                <div class="site-footer__col">
                <h3><?php echo e(__('website.footer.destinations')); ?></h3>
                <div class="site-footer__links">
                    <?php $__empty_1 = true; $__currentLoopData = ($footerRegions ?? collect())->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('website.motels.index', ['region' => $region->id])); ?>">
                            <?php echo e($region->name); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <span><?php echo e(__('website.footer.expanding')); ?></span>
                    <?php endif; ?>
                </div>
            </div>


            <div class="site-footer__col">
                <h3><?php echo e(__('website.footer.properties')); ?></h3>
                <div class="site-footer__links">
                    <?php $__empty_1 = true; $__currentLoopData = ($footerMotelTypes ?? collect())->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motelType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('website.motels.index', ['motel_type' => $motelType->id])); ?>">
                            <?php echo e($motelType->name); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <span><?php echo e(__('website.footer.coming_soon')); ?></span>
                    <?php endif; ?>
                </div>

              
            </div>

            <div class="site-footer__col">
                <h3><?php echo e(__('website.footer.room_types')); ?></h3>
                <div class="site-footer__links">
                <?php if(($footerRoomTypes ?? collect())->isNotEmpty()): ?>
                    <div class="site-footer__pill-list">
                        <?php $__currentLoopData = ($footerRoomTypes ?? collect())->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(is_object($roomType) && ($roomType->id ?? false)): ?>
                                    <a class="site-footer__pill" href="<?php echo e(route('website.motels.index', ['room_type' => $roomType->id])); ?>"><?php echo e($roomType->name ?? $roomType); ?></a>
                                <?php elseif(is_array($roomType) && ($roomType['id'] ?? false)): ?>
                                    <a class="site-footer__pill" href="<?php echo e(route('website.motels.index', ['room_type' => $roomType['id']])); ?>"><?php echo e($roomType['name'] ?? $roomType); ?></a>
                            <?php else: ?>
                                    <span class="site-footer__pill"><?php echo e(is_object($roomType) ? ($roomType->name ?? $roomType) : (is_array($roomType) ? ($roomType['name'] ?? $roomType) : $roomType)); ?></span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <span><?php echo e(__('website.footer.coming_soon')); ?></span>
                <?php endif; ?>
                </div>
            </div>

           

            <div class="site-footer__col">
                <h3><?php echo e(__('website.footer.connect')); ?></h3>
                <div class="site-footer__social">
                    <a href="#" aria-label="Facebook">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 22v-8h3l1-3h-4V8a1 1 0 0 1 1-1h3V4h-3a4 4 0 0 0-4 4v3H8v3h2v8h3Z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 7a5 5 0 1 0 5 5 5.006 5.006 0 0 0-5-5Zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3Zm5.5-8.9a1.17 1.17 0 1 0 1.17 1.17 1.17 1.17 0 0 0-1.17-1.17ZM21 7.5a5.5 5.5 0 0 0-5.5-5.5h-7A5.5 5.5 0 0 0 3 7.5v7A5.5 5.5 0 0 0 8.5 20h7A5.5 5.5 0 0 0 21 14.5Zm-2 7A3.5 3.5 0 0 1 15.5 18h-7A3.5 3.5 0 0 1 5 14.5v-7A3.5 3.5 0 0 1 8.5 4h7A3.5 3.5 0 0 1 19 7.5Z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 5.92a7.53 7.53 0 0 1-2.12.58 3.69 3.69 0 0 0 1.64-2.02 7.42 7.42 0 0 1-2.36.93 3.7 3.7 0 0 0-6.3 3.38 10.5 10.5 0 0 1-7.64-3.88 3.68 3.68 0 0 0 1.14 4.93 3.66 3.66 0 0 1-1.67-.46v.05a3.7 3.7 0 0 0 2.97 3.63 3.72 3.72 0 0 1-1.66.06 3.7 3.7 0 0 0 3.46 2.57A7.42 7.42 0 0 1 2 18.09a10.46 10.46 0 0 0 5.65 1.66c6.79 0 10.5-5.63 10.5-10.5 0-.16 0-.31-.01-.47A7.46 7.46 0 0 0 22 5.92Z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="LinkedIn">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 3a2 2 0 1 1-2 2 2 2 0 0 1 2-2Zm1.5 6h-3A.5.5 0 0 0 3 9.5v11a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-11A.5.5 0 0 0 6.5 9Zm11.75-.12A3.75 3.75 0 0 0 15 9.86a4.86 4.86 0 0 0-1.31-.18A4.68 4.68 0 0 0 11 11.32v-1.82a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v11a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-6a2.38 2.38 0 0 1 .11-.77 1.82 1.82 0 0 1 1.74-1.23c1 0 1.55.73 1.55 1.91v6.09a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-6.86c0-3.3-1.76-4.83-3.75-4.83Z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="site-footer__bottom">
            <div><?php echo e(__('website.footer.copyright', ['year' => now()->year])); ?></div>
            <div class="site-footer__language-switch">
                <a href="<?php echo e(route('website.language.switch', 'en')); ?>" class="<?php echo e($currentLocale === 'en' ? 'is-active' : ''); ?>"><?php echo e(__('website.language.english')); ?></a>
                <a href="<?php echo e(route('website.language.switch', 'sw')); ?>" class="<?php echo e($currentLocale === 'sw' ? 'is-active' : ''); ?>"><?php echo e(__('website.language.swahili')); ?></a>
            </div>
        </div>
    </div>
</footer><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/websitepages/components/footer.blade.php ENDPATH**/ ?>